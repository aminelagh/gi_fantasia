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

class AdminArticlesController extends Controller
{
  public function articles(Request $request){

    //dd( Inspiring::quote() );
    $where_id_famille = "";

    if($request->has('submitFiltre')){
      //  dd($request->all());
      if($request->id_famille != 'null' ) {$where_id_famille = " and a.id_famille = ".$request->id_famille." ";}
    }

    $sites = collect(DB::select("SELECT s.id_site, s.libelle, s.created_at, so.libelle as libelle_societe FROM sites s LEFT JOIN societes so ON s.id_societe=so.id_societe"));
    $familles = collect(DB::select("SELECT f.id_famille, f.libelle, c.libelle as libelle_famille FROM familles f LEFT JOIN categories c on c.id_categorie = f.id_categorie;"));
    $unites = Unite::all();
    $title = "Articles";
    $articles = collect(DB::select(
      "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille,
      u.libelle as libelle_unite
      FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
      LEFT JOIN unites u on u.id_unite=a.id_unite
      WHERE true " . $where_id_famille . "
      ORDER BY id_article asc;"
    ));

    $view = view('admin.articles')->with(compact('articles','familles','sites','unites','title'));

    if($request->has('submitFiltre')){
      if($request->has('id_famille') && $request->id_famille != "null"){
        $view->with('selected_id_famille',$request->id_famille);
      }
    }
    return $view;
  }

  //Export Articles ------------------------------------------------------------
  public function exportArticles(Request $request){
    try{
      Excel::create('Articles', function($excel) {
        $excel->sheet('Articles', function($sheet) {

          $articles = collect(DB::select(
            "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille,
            u.libelle as libelle_unite
            FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
            LEFT JOIN unites u on u.id_unite=a.id_unite
            WHERE true
            ORDER BY id_article asc;"
          ));
          $sheet->appendRow(array("id_article","code","designation","unite","famille"));
          foreach ($articles as $item) {
            $sheet->appendRow(array( $item->id_article,$item->code,$item->designation,$item->libelle_unite,$item->libelle_famille));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }

  public function importArticles(Request $request){
    $file = $request->file('file');
    if($file->getClientOriginalExtension() != "xls"){
      return redirect()->back()->with('alert_warning',"Veuillez importer un fichier excel.");
    }
    //Move Uploaded File
    $destinationPath = 'uploads';
    $file->move($destinationPath,$file->getClientOriginalName());

    try{

      Excel::load('uploads/'.$file->getClientOriginalName())->chunk(1000000, function($results)
      {
        $hasError = false;
        $errors = [];
        $i = 2;
        //foreach row ----------------------------------------------------------
        foreach($results as $row){
          //try{
          $rowHasError = false;
          // get IDs
          $id_unite = Unite::getID($row->unite);
          $id_famille = Famille::getID($row->famille);
          //check if items exist
          if($id_unite == null){$rowHasError = true;  array_push($errors,array("index"=> $i, "errorUnite"=> true ));}
          if($id_famille == null){$rowHasError = true;  array_push($errors,array("index"=> $i, "errorFamille"=> true ));}

          //no row Error
          if($rowHasError == false){
            //check if id_article exists
            if($row->id_article != null && Article::exists($row->id_article)) {
              //update Article
              if(Article::updateArticle($row->id_article, $row->code, $row->designation, $id_unite, $id_famille)){
              }else{  $hasError = true; array_push($errors,array("index"=> $i, "errorArticle"=> true ));  }
            }
            //new article
            else{
              if(Article::addArticle($row->code, $row->designation, $id_unite, $id_famille)){
                //no problem adding article and site
              }else{  $hasError = true; array_push($errors,array("index"=> $i, "errorArticle"=> true ));  }
            }
          }
          //there is a row error
          else{
            $hasError = true;
          }
          $i++;
        }
        //end foreach row ------------------------------------------------------
        if($hasError){
          $errorMessage = "";
          $errorMessageDanger = "";
          foreach ($errors as $error) {
            if(isset($error['errorUnite'])) $errorMessage = $errorMessage + "<li>Ligne: ".$error['index'].". unité n'existe pas.</li>";
            if(isset($error['errorFamille'])) $errorMessage = $errorMessage + "<li>Ligne: ".$error['index'].". famille n'existe pas.</li>";
            if(isset($error['error'])) $errorMessageDanger = $errorMessageDanger + "<li>Ligne: ".$error['index'].". ".$error['error'].".</li>";
          }
          return redirect()->back()->with('alert_warning',$errorMessage)->with('alert_danger',$errorMessageDanger);
        }
        else return redirect()->back()->with('alert_success',"Import des articles réussi.");
      });
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"erreur d'importation des articles, veuillez vérifier la validité du document chargé.<br>Message d'erreur: ".$e->getMessage());
    }
    return redirect()->back()->with('alert_success',"Chargement des articles réussi");
  }

  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //add Article ****************************************************************
  public function addArticle(Request $request){
    try{
      Article::addArticle($request->code, $request->designation, $request->id_unite, $request->id_famille);

    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article créé");
  }
  //Delete Article *************************************************************
  public function deleteArticle(Request $request){
    try{
      if(Inventaire::where('id_article',$request->id_article)->get()->first()!=null || Article_site::where('id_article',$request->id_article)->get()->first()!=null){
        return redirect()->back()->with('alert_warning',"Élément utilisé ailleurs, donc impossible de le supprimer.");
      }
      else{
        $item = Article::find($request->id_article);
        $item->delete();
      }

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article supprimé");
  }
  //update Article *************************************************************
  public function updateArticle(Request $request){
    try{
      Article::updateArticle($request->id_article,$request->code,$request->designation,$request->id_unite,$request->id_famille);

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article modifié");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

  public function exportArticles2(Request $request){
    try{

      $where_id_famille = "";
      $where_id_site = "";

      if($request->id_famille != 'null' ) {
        $id_famille = $request->id_famille;
        $where_id_famille = " and a.id_famille ".$id_famille." ";
      }

      if($request->id_site != 'null' ) {
        $id_site = $request->id_site;
        $where_id_site = " and s.id_site = ".$id_site." ";
      }
      $GLOBALS['where_id_famille'] = $where_id_famille;
      $GLOBALS['where_id_site'] = $where_id_site;

      Excel::create('Articles', function($excel) {
        $excel->sheet('Articles', function($sheet) {

          $where_id_famille = $GLOBALS['where_id_famille'];
          $where_id_site = $GLOBALS['where_id_site'];

          $articles = collect(DB::select(
            "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille,
            u.libelle as libelle_unite, s.libelle as libelle_site, s.id_site, article_site.id_article_site
            FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
            LEFT JOIN unites u on u.id_unite=a.id_unite
            LEFT JOIN article_site on article_site.id_article=a.id_article
            LEFT JOIN sites s on s.id_site=article_site.id_site
            WHERE true " . $where_id_famille . " ".$where_id_site."
            ORDER BY a.id_article asc;"
          ));

          $sheet->appendRow(array("id_article","code","designation","unite","famille","site"));
          foreach ($articles as $item) {
            $sheet->appendRow(array( $item->id_article,$item->code,$item->designation,$item->libelle_unite,$item->libelle_famille,$item->libelle_site));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }

  public function importArticles2(Request $request){
    $file = $request->file('file');
    if($file->getClientOriginalExtension() != "xls"){
      return redirect()->back()->with('alert_warning',"Veuillez importer un fichier excel.");
    }
    //Move Uploaded File
    $destinationPath = 'uploads';
    $file->move($destinationPath,$file->getClientOriginalName());

    /*Excel::load('uploads/'.$file->getClientOriginalName(), function($reader) {
    //Excel::selectSheetsByIndex(0)->load();
    //$x = $reader->get(array("id_article","Code","Famille","Site","Designation","Unité","date de creation"));
    //dump($x);
  });*/
  try{

    Excel::load('uploads/'.$file->getClientOriginalName())->chunk(1000000, function($results)
    {
      $hasError = false;
      $errors = [];
      $i = 2;
      //foreach row ----------------------------------------------------------
      foreach($results as $row){
        //try{
        $rowHasError = false;
        // get IDs
        $id_unite = Unite::getID($row->unite);
        $id_famille = Famille::getID($row->famille);
        $id_site = Site::getID($row->site);
        //check if items exist
        if($id_unite == null){$rowHasError = true;  array_push($errors,array("index"=> $i, "errorUnite"=> true ));}
        if($id_famille == null){$rowHasError = true;  array_push($errors,array("index"=> $i, "errorFamille"=> true ));}
        if($id_site == null){$rowHasError = true;  array_push($errors,array("index"=> $i, "errorSite"=> true ));}

        //no row Error
        if($rowHasError == false){
          //check if id_article exists
          if($row->id_article != null && Article::exists($row->id_article)) {
            //update Article / site
            $id_article_site = Article_site::where('id_article', $row->id_article)->where('id_site',$id_site)->get()->first()->id_article_site;
            if(Article::updateArticle2($row->id_article, $row->code, $row->designation, $id_unite, $id_famille, $id_site, $id_article_site)){
            }else{  $hasError = true; array_push($errors,array("index"=> $i, "errorArticle"=> true ));  }
          }
          //new article
          else{
            if(Article::addArticle($row->code, $row->designation, $id_unite, $id_famille, $id_site)){
              //no problem adding article and site
            }else{  $hasError = true; array_push($errors,array("index"=> $i, "errorArticle"=> true ));  }
          }
        }
        //there is a row error
        else{
          $hasError = true;
        }
        //}catch(Exception $e){ $hasError = true; array_push($errors,array("index"=> $i, "error"=> "Erreur: ".$e->getMessage()." ")); dd($e->getMessage());  }
        $i++;
      }
      //end foreach row ------------------------------------------------------
      if($hasError){
        $errorMessage = "";
        $errorMessageDanger = "";
        foreach ($errors as $error) {
          if(isset($error['errorUnite'])) $errorMessage = $errorMessage + "<li>Ligne: ".$error['index'].". unité n'existe pas.</li>";
          if(isset($error['errorFamille'])) $errorMessage = $errorMessage + "<li>Ligne: ".$error['index'].". famille n'existe pas.</li>";
          if(isset($error['errorSite'])) $errorMessage = $errorMessage + "<li>Ligne: ".$error['index'].". site n'existe pas.</li>";
          if(isset($error['error'])) $errorMessageDanger = $errorMessageDanger + "<li>Ligne: ".$error['index'].". ".$error['error'].".</li>";
        }
        return redirect()->back()->with('alert_warning',$errorMessage)->with('alert_danger',$errorMessageDanger);
      }
      else return redirect()->back()->with('alert_success',"Import des articles réussi.");
    });
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"erreur d'importation des articles, veuillez vérifier la validité du document chargé.<br>Message d'erreur: ".$e->getMessage());
  }
  return redirect()->back()->with('alert_success',"Chargement des articles réussi");
}

}
