<?php

namespace App\Http\Controllers;

use Closure;
use \Exception;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\User;
use \App\Models\Inventaire;
use \App\Models\Famille;
use \App\Models\Categorie;
use \App\Models\Societe;
use \App\Models\Site;
use \App\Models\Zone;
use \App\Models\Article_site;
use \App\Models\Article;
use \App\Models\Unite;
use \DB;
use Excel;
use Illuminate\Foundation\Inspiring;


class ControleurArticlesController extends Controller
{
  public function articles(Request $request){
    $where_id_famille = "";
    $where_id_site = "";

    if($request->has('submitFiltre')){
      if($request->id_famille != 'null' ) { $where_id_famille = " and a.id_famille = ".$request->id_famille." ";}
      if($request->id_site != 'null' ) { $where_id_site = " and s.id_site = ".$request->id_site." ";}
    }

    $familles = collect(DB::select("SELECT f.id_famille, f.libelle, c.libelle as libelle_famille FROM familles f LEFT JOIN categories c on c.id_categorie = f.id_categorie;"));
    $unites = Unite::all();
    $title = "Articles";

    $articles = collect(DB::select(
      "SELECT sa.*,
      a.code, a.designation, a.id_famille, a.id_unite,
      u.libelle as libelle_unite,
      s.libelle as libelle_site,
      so.libelle as libelle_societe,
      f.libelle as libelle_famille
      FROM article_site sa LEFT JOIN articles a on a.id_article=sa.id_article
      LEFT JOIN sites s on s.id_site=sa.id_site
      LEFT JOIN societes so on so.id_societe=s.id_societe
      LEFT JOIN unites u on u.id_unite=a.id_unite
      LEFT JOIN familles f on f.id_famille=a.id_famille
      WHERE sa.id_site = ".Session::get('id_site')." " . $where_id_famille . " " . $where_id_site . " ORDER BY a.code asc;"
    ));

    $view = view('controleur.articles')->with(compact('articles','familles','unites','title'));

    if($request->has('submitFiltre')){
      if($request->has('id_famille') && $request->id_famille != "null"){$view->with('selected_id_famille',$request->id_famille);}
      if($request->has('id_site') && $request->id_site != "null" ){$view->with('selected_id_site',$request->id_site);}
    }

    return $view;
  }

  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //add Article ****************************************************************
  public function addArticle(Request $request){
    try{
      $id_article = Article::getNextID();

      $item = new Article();
      $item->id_article = $id_article;
      $item->id_famille = $request->id_famille;
      $item->id_unite = $request->id_unite;
      $item->code = $request->code;
      $item->designation = $request->designation;
      $item->save();

      $article_site = new Article_site();
      $article_site->id_article = $id_article;
      $article_site->id_site = Session::get('id_site');
      $article_site->save();

    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article créé");
  }

  //Delete Article *************************************************************
  public function deleteArticle(Request $request){
    try{
      if(Inventaire::where('id_article',$request->id_article)->get()->first()!=null){
        return redirect()->back()->with('alert_warning',"Élément utilisé ailleurs, donc impossible de le supprimer.");
      }
      else{
        $item = Article::find($request->id_article);
        $item->delete();
        $article_site = Article_site::find($request->id_article_site);
        $article_site->delete();
      }

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article supprimé");
  }

  //update Article *************************************************************
  public function updateArticle(Request $request){
    try{
      //dd($request->all());
      $item = Article::find($request->id_article);
      $item->id_famille = $request->id_famille;
      $item->id_unite = $request->id_unite;
      $item->code = $request->code;
      $item->designation = $request->designation;
      $item->save();

      $article_site = Article_site::find($request->id_article_site);
      $article_site->id_article = $request->id_article;
      $article_site->id_site = Session::get('id_site');
      $article_site->save();

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article modifié");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
}
