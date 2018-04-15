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
use \App\Models\Article;
use \App\Models\Unite;
use \DB;

class AdminArticlesController extends Controller
{
  public function articles(Request $request){

    $zones = collect(DB::select("select z.id_zone, z.libelle, z.created_at, z.id_site, s.libelle as libelle_s from zones z LEFT JOIN sites s on z.id_site=s.id_site limit 2;"));
    $categories = collect(DB::select("select c.id_categorie, c.id_famille, c.created_at, c.libelle as libelle, f.libelle as libelle_famille from categories c LEFT JOIN familles f on c.id_famille = f.id_famille;"));
    $unites = Unite::all();

    $articles = collect(DB::select(
      "SELECT a.id_article, a.id_categorie, a.id_zone, a.id_unite, a.code, a.designation, a.created_at, c.libelle as libelle_categorie, z.libelle as libelle_zone, u.libelle as libelle_unite
      FROM articles a LEFT JOIN categories c on c.id_categorie=a.id_categorie LEFT JOIN zones z on z.id_zone=a.id_zone LEFT JOIN unites u on u.id_unite=a.id_unite;
    "));

    //$articles = Throttle::paginate($this->posts_per_page);

    if($request->ajax()) {
      return [
        'articles' => view('admin.moreData.articles')->with(compact('articles'))->render(),
        'next_page' => $articles->nextPageUrl()
      ];
    }
    return view('admin.articles')->with(compact('articles','zones','unites','categories'));
  }


  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
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
  //add Article ****************************************************************
  public function addArticle(Request $request){
    try{
      $item = new Article();
      $item->id_categorie = $request->id_categorie;
      $item->id_zone = $request->id_zone;
      $item->id_unite = $request->id_unite;
      $item->code = $request->code;
      $item->designation = $request->designation;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de l'article.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Article créé");
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
}
