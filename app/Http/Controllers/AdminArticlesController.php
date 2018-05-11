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
    $where_id_site = "";

    if($request->has('submitFiltre')){
      //  dd($request->all());
      if($request->id_famille != 'null' ) {$where_id_famille = " and a.id_famille = ".$request->id_famille." ";}
      if($request->id_site != 'null' ) {$where_id_site = " and s.id_site = ".$request->id_site." ";}
    }

    $sites = collect(DB::select("SELECT s.id_site, s.libelle, s.created_at, so.libelle as libelle_societe FROM sites s LEFT JOIN societes so ON s.id_societe=so.id_societe"));
    $familles = collect(DB::select("SELECT f.id_famille, f.libelle, c.libelle as libelle_famille FROM familles f LEFT JOIN categories c on c.id_categorie = f.id_categorie;"));
    $unites = Unite::all();
    $title = "Articles";
    $articles = collect(DB::select(
      "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille,
      u.libelle as libelle_unite, s.libelle as libelle_site, s.id_site, article_site.id_article_site
      FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
      LEFT JOIN unites u on u.id_unite=a.id_unite
      LEFT JOIN article_site on article_site.id_article=a.id_article
      LEFT JOIN sites s on s.id_site=article_site.id_site
      WHERE true " . $where_id_famille . " ".$where_id_site." ;"
    ));

    $view = view('admin.articles')->with(compact('articles','familles','sites','unites','title'));

    if($request->has('submitFiltre')){
      if($request->has('id_famille') && $request->id_famille != "null"){
        $view->with('selected_id_famille',$request->id_famille);
      }
      if($request->has('id_site') && $request->id_site != "null" ){
        $view->with('selected_id_site',$request->id_site);
      }
    }

    return $view;
  }


  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //add Article ****************************************************************
  public function addArticle(Request $request){
    try{
      $articles = Article::where('code',$request->code)->get();
      foreach($articles as $item){
        $id_article = $item->id_article;
        $article_sites = Article_site::where('id_article',$id_article)->get();
        foreach($article_sites as $as){
          if($as->id_site == $request->id_site){
            return redirect()->back()->withInput()->with('alert_warning',"ce code est déjà utilisé pour un autre article dans ce site.");
          }
        }
      }
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
      $article_site->id_site = $request->id_site;
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

      $articles = Article::where('code',$request->code)->get();
      foreach($articles as $item){
        $id_article = $item->id_article;
        $article_sites = Article_site::where('id_article',$id_article)->get();
        foreach($article_sites as $as){
          if($as->id_site == $request->id_site){
            return redirect()->back()->withInput()->with('alert_warning',"ce code est déjà utilisé pour un autre article dans ce site.");
          }
        }
      }

      $item = Article::find($request->id_article);
      $item->id_famille = $request->id_famille;
      $item->id_unite = $request->id_unite;
      $item->code = $request->code;
      $item->designation = $request->designation;
      $item->save();

      $article_site = Article_site::find($request->id_article_site);
      $article_site->id_article = $request->id_article;
      $article_site->id_site = $request->id_site;
      $article_site->save();

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article modifié");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

  public function exportArticles(Request $request){
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

  public function importArticles(Request $request){
    $file = $request->file('file');
    if($file->getClientOriginalExtension() != "xls"){
      return redirect()->back()->with('alert_warning',"Veuillez importer un fichier excel.");
    }
    /*
    //Display File Name
    echo 'File Name: '.$file->getClientOriginalName();
    //Display File Extension
    echo 'File Extension: '.$file->getClientOriginalExtension();
    //Display File Real Path
    echo 'File Real Path: '.$file->getRealPath();
    //Display File Size
    echo 'File Size: '.$file->getSize();
    //Display File Mime Type
    echo 'File Mime Type: '.$file->getMimeType();*/

    //Move Uploaded File
    $destinationPath = 'uploads';
    $file->move($destinationPath,$file->getClientOriginalName());

    Excel::load('uploads/'.$file->getClientOriginalName(), function($reader) {
      //Excel::selectSheetsByIndex(0)->load();
      //$x = $reader->get(array("id_article","Code","Famille","Site","Designation","Unité","date de creation"));
      //dump($x);
    });
    try{

      Excel::load('uploads/'.$file->getClientOriginalName())->chunk(1000000, function($results)
      {
        $rowHasError = false;
        $errors = [];
        $i = 2;
        foreach($results as $row){
          try{
            /*  if(!is_numeric($row->id_article) || !is_numeric($row->id_famille) || !is_numeric($row->id_unite)){
            throw new Exception("Erreur dans la ligne: ".$i);
          }*/
          echo "id_article: $row->id_article, code: $row->code, designation: $row->designation, unite: $row->unite, famille: $row->famille, site: $row->site <hr>";
          $id_unite = Unite::getID($row->unite);
          $id_famille = Famille::getID($row->famille);
          $id_site = Site::getID($row->site);
          if($id_unite == null){
            $rowHasError = true;
          }
        }catch(Exception $e){
          //return redirect()->back()->with('alert_danger',"erreur d'importation des articles, veuillez vérifier la validité du document chargé.<br>Message d'erreur: ".$e->getMessage());
        }


        //$this->saveArticle($row->id_article, $row->id_famille, $row->id_unite, $row->code, $row->designation);
        //$this->saveFamille($row->id_famille, $row->famille);
        //$this->saveUnite($row->id_unite, $row->unite);
        //$this->saveArticleSite($row->id_article_site, $row->id_article, $row->id_site);
      }
    });
  }catch(Exception $e){
    //return redirect()->back()->with('alert_danger',"erreur d'importation des articles, veuillez vérifier la validité du document chargé.<br>Message d'erreur: ".$e->getMessage());
  }
  //return redirect()->back()->with('alert_success',"Chargement des articles réussi");
}

public static function saveArticle($id_article, $id_famille, $id_unite, $code, $designation){
  $item = Article::find($id_article);
  if($item == null){
    $item = new Article();
    $item->id_article = $id_article;
  }
  $item->id_famille = $id_famille;
  $item->id_unite = $id_unite;
  $item->code = $code;
  $item->designation = $designation;
  $item->save();
}
public static function saveUnite($id_unite, $libelle_unite){
  $item = Unite::find($id_unite);
  if($item == null){
    $item = new Unite();
    $item->id_unite = $id_unite;
  }
  $item->libelle = $libelle_unite;
  $item->save();
}
public static function saveFamille($id_famille, $libelle_famille){
  $item = Famille::find($id_famille);
  if($item == null){
    $item = new Famille();
    $item->id_famille = $id_famille;
  }
  $item->libelle = $libelle_famille;
  $item->save();
}

public static function saveArticleSite($id_article_site, $id_article, $id_site){
  $item = Article_site::find($id_article_site);
  if($item == null){
    $item = new Article_site();
    $item->id_article_site = $id_article_site;
  }
  $item->id_article = $id_article;
  $item->id_site = $id_site;
  $item->save();
}
}
