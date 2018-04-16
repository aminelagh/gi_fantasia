<?php

namespace App\Http\Controllers;

use Closure;
use \Exception;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\User;
use \App\Models\Role_user;
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

class AdminArticlesController extends Controller
{
  public function articles(Request $request){

    $sites = collect(DB::select("SELECT s.id_site, s.libelle, s.created_at, so.libelle as libelle_societe FROM sites s LEFT JOIN societes so ON s.id_societe=so.id_societe"));
    $familles = collect(DB::select("SELECT f.id_famille, f.libelle, c.libelle as libelle_famille FROM familles f LEFT JOIN categories c on c.id_categorie = f.id_categorie;"));
    $unites = Unite::all();

    $articles = collect(DB::select(
      "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille, u.libelle as libelle_unite, s.libelle as libelle_site
      FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
      LEFT JOIN unites u on u.id_unite=a.id_unite
      LEFT JOIN article_site on article_site.id_article=a.id_article
      LEFT JOIN sites s on s.id_site=article_site.id_site;
      ;"
    ));

    //$articles = Throttle::paginate($this->posts_per_page);

    if($request->ajax()) {
      return [
        'articles' => view('admin.moreData.articles')->with(compact('articles'))->render(),
        'next_page' => $articles->nextPageUrl()
      ];
    }
    return view('admin.articles')->with(compact('articles','sites','unites','familles'));
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
      $item = Article::find($request->id_article);
      $item->delete();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article supprimé");
  }
  //update Article *************************************************************
  public function updateArticle(Request $request){
    try{
      $item = Article::find($request->id_article);
      $item->id_categorie = $request->id_categorie;
      $item->id_zone = $request->id_zone;
      $item->id_unite = $request->id_unite;
      $item->code = $request->code;
      $item->designation = $request->designation;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article modifié");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

  public function exportArticles(){
    try{
      Excel::create('Gestion Inventaire', function($excel) {

        $excel->sheet('Articles', function($sheet) {
          $articles = collect(DB::select(
            "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille, u.libelle as libelle_unite, s.libelle as libelle_site
            FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
            LEFT JOIN unites u on u.id_unite=a.id_unite
            LEFT JOIN article_site on article_site.id_article=a.id_article
            LEFT JOIN sites s on s.id_site=article_site.id_site;
            ;"
          ));
          $sheet->appendRow(array( "id_article","Code","Famille","Site","Designation","Unité","date de creation"));
          foreach ($articles as $item) {
            $sheet->appendRow(array( $item->id_article,$item->code,$item->libelle_famille,$item->libelle_site,$item->designation,$item->libelle_unite,$item->created_at));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }

  public function addArticles(Request $request){
    $file = $request->file('file');
    if($file->getClientOriginalExtension() != "xls"){
      return redirect()->back()->with('alert_warning',"Veuillez importer un fichier excel.");
    }
    /*
    //Display File Name
    echo 'File Name: '.$file->getClientOriginalName();
    echo '<br>';

    //Display File Extension
    echo 'File Extension: '.$file->getClientOriginalExtension();
    echo '<br>';

    //Display File Real Path
    echo 'File Real Path: '.$file->getRealPath();
    echo '<br>';

    //Display File Size
    echo 'File Size: '.$file->getSize();
    echo '<br>';

    //Display File Mime Type
    echo 'File Mime Type: '.$file->getMimeType();*/

    //Move Uploaded File
    $destinationPath = 'uploads';
    $file->move($destinationPath,$file->getClientOriginalName());

    Excel::load('uploads/'.$file->getClientOriginalName(), function($reader) {
      //Excel::selectSheetsByIndex(0)->load();
      $x = $reader->get(array("id_article","Code","Famille","Site","Designation","Unité","date de creation"));
      dump($x);
    });

    Excel::filter('chunk')->load('uploads/'.$file->getClientOriginalName())->chunk(2, function($results)
    {
      foreach($results as $row)
      {
        echo "id: ".$row->id_article;
        echo "code: ".$row->code;
        echo "famille: ".$row->famille;
        echo "designation: ".$row->designation;
        echo "<hr>";
      }
    });
  }
}
