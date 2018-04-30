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
use \App\Models\Throttle;
use \DB;

class ControleurController extends Controller
{
  public function home(Request $request){

    $title = "Controleur";
    //$users = collect(DB::select("select u.id as id_user,u.nom, u.prenom,r.slug,r.name,u.last_login,u.created_at,u.login from users u LEFT JOIN role_users ru on ru.user_id = u.id LEFT JOIN roles r on r.id = ru.role_id;"));
    //$roles = Role::all();
    $categories = Categorie::all();
    $familles = collect(DB::select(
      "SELECT f.libelle, f.id_famille, f.id_categorie, f.created_at, c.libelle as libelle_categorie from familles f LEFT JOIN categories c on c.id_categorie = f.id_categorie;"
    ));

    $societes = Societe::all();
    $sites = collect(DB::select("select s.id_site, s.id_societe,s.libelle,s.created_at, so.libelle as libelle_so from sites s LEFT JOIN societes so on s.id_societe = so.id_societe;"));
    $zones = collect(DB::select("select z.id_zone, z.libelle, z.created_at, z.id_site, s.libelle as libelle_s from zones z LEFT JOIN sites s on z.id_site=s.id_site;"));

    //$unites = Unite::all();
    return view('controleur.dashboard')->with(compact('familles','categories','societes','sites','zones','title'));
    //  return view('admin.dashboard')->withUsers($users)->withRoles($roles);//->with('alert_info',"Hola");
  }


  public function articles(Request $request){
    $where_id_famille = "";
    $where_id_site = "";

    if($request->has('submitFiltre')){
      if($request->id_famille != 'null' ) { $where_id_famille = " and a.id_famille = ".$request->id_famille." ";}
      if($request->id_site != 'null' ) {    $where_id_site = " and s.id_site = ".$request->id_site." ";}
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

    $view = view('controleur.articles')->with(compact('articles','familles','sites','unites','title'));

    if($request->has('submitFiltre')){
      if($request->has('id_famille') && $request->id_famille != "null"){$view->with('selected_id_famille',$request->id_famille);}
      if($request->has('id_site') && $request->id_site != "null" ){$view->with('selected_id_site',$request->id_site);}
    }

    return $view;
  }


  //updating Session variable after updating the current user's Profil
  public static function updateSession(){
    try{
      $user = User::find(Session::get('id_user'));
      Session::put('login', $user->login);
      Session::put('nom', $user->nom);
      Session::put('prenom', $user->prenom);
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de mise a jour de votre session.<br>Message d'erreur: ".$e->getMessage());
    }
  }
}
