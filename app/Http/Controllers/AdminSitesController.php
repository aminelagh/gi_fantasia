<?php

namespace App\Http\Controllers;

use Closure;
use \Exception;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\User;
use \App\Models\Article_site;
use \App\Models\Famille;
use \App\Models\Categorie;
use \App\Models\Societe;
use \App\Models\Site;
use \App\Models\Zone;
use \DB;
use Excel;

class AdminSitesController extends Controller
{
  public function site($id_site,Request $request){
    $site = Site::find($id_site);
    if($site ==null){
      return redirect()->back()->with('alert_info',"Le site choisi n'exite pas.");
    }

    //createArticleSite
    //ajouter les articles choisi au site
    if($request->has('submitAddArticlesToSite')){
      $articles = $request->articles;
      $itemCreated = false;
      if(isset($articles)){
        foreach($articles as $id_article){
          $item = new Article_site();
          $item->id_site = $id_site;
          $item->id_article = $id_article;
          $item->save();
          $itemCreated = true;
        }
      }

      if($itemCreated) {
        return redirect()->route('site',[$id_site])->with('alert_success',"Action réussie");
      }else{
        return redirect()->route('site',[$id_site])->with('alert_info',"Aucun article ajouté au site.");
      }
    }
    //-----------------------------

    $articles = collect(DB::select(
      "SELECT a.id_article, a.code, a.designation, a.id_unite, a.id_famille, u.libelle as libelle_unite, f.libelle as libelle_famille
      FROM articles a
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      LEFT JOIN familles f ON f.id_famille=a.id_famille
      WHERE a.id_article NOT IN (SELECT id_article FROM article_site WHERE id_site=".$id_site.");"
    ));
    $article_sites = collect(DB::select(
      "SELECT a_s.id_article_site, a_s.id_site, a.id_article, a.code, a.designation,a.id_unite, a.id_famille,
      u.libelle as libelle_unite,
      f.libelle as libelle_famille
      FROM article_site a_s
      LEFT JOIN articles a ON a.id_article=a_s.id_article
      LEFT JOIN familles f ON f.id_famille=a.id_famille
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      WHERE id_site=".$id_site."
      ORDER BY id_article_site asc;"
    ));
    $title = $site->libelle;
    $view = view('admin.site')->with(compact('articles','title','article_sites','site'));

    return $view;
  }



  public function deleteArticleSite(Request $request){
    try{
      if(Inventaire::where('id_article_site',$request->id_article_site)->get()->first()!=null){
        return redirect()->back()->with('alert_warning',"Élément utilisé ailleurs, donc impossible de le supprimer");
      }
      else{
        $item = Article_site::find($request->id_article_site);
        $item->delete();
      }
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'element.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element supprimé");
  }

  public function exportArticleSites(Request $request){
    try{

      $GLOBALS['id_site'] = $request->id_site;
      Excel::create('Articles', function($excel) {
        $excel->sheet('Articles', function($sheet) {

          $id_site = $GLOBALS['id_site'];

          $article_sites = collect(DB::select(
            "SELECT a_s.id_article_site, a_s.id_site, a.id_article, a.code, a.designation,a.id_unite, a.id_famille,
            u.libelle as libelle_unite,
            f.libelle as libelle_famille,
            s.libelle as libelle_site
            FROM article_site a_s
            LEFT JOIN articles a ON a.id_article=a_s.id_article
            LEFT JOIN familles f ON f.id_famille=a.id_famille
            LEFT JOIN unites u ON u.id_unite=a.id_unite
            LEFT JOIN sites s ON s.id_site=a_s.id_site
            WHERE a_s.id_site=".$id_site.";"
          ));

          $sheet->appendRow(array("id_article_site","id_article","code","designation","unite","famille","site"));
          foreach ($article_sites as $item) {
            $sheet->appendRow(array( $item->id_article_site,$item->id_article,$item->code,$item->designation,$item->libelle_unite,$item->libelle_famille,$item->libelle_site));
          }

        });
      })->export('xls');

    }catch(Exception $e){
      dd($e->getMessage());
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ");
    }
  }


  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //Delete Site *************************************************************
  public function deleteSite(Request $request){
    try{
      if(Zone::where('id_site',$request->id_site)->get()->first()!=null || Article_site::where('id_site',$request->id_site)->get()->first()!=null){
        return redirect()->back()->with('alert_warning',"Élément utilisé ailleurs, donc impossible de le supprimer");
      }
      else{
        $item = Site::find($request->id_site);
        $item->delete();
      }

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression du site.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Site supprimé");
  }
  //add Site ****************************************************************
  public function addSite(Request $request){
    try{
      Site::addSite($request->libelle, $request->id_societe);
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de création du site.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Site créé");
  }
  //update Site *************************************************************
  public function updateSite(Request $request){
    try{
      Site::addSite($request->id_site,$request->libelle, $request->id_societe);
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification du site.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Site modifié");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

}
