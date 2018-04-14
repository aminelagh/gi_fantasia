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

class AdminController extends Controller
{
  protected $posts_per_page = 10;

  public function home(){
    $users = collect(DB::select("select u.id as id_user,u.nom, u.prenom,r.slug,r.name,u.last_login,u.created_at,u.login from users u LEFT JOIN role_users ru on ru.user_id = u.id LEFT JOIN roles r on r.id = ru.role_id;"));
    $roles = Role::all();
    $familles = Famille::all();
    $categories = collect(DB::select("select c.id_categorie, c.id_famille, c.created_at, c.libelle as libelle, f.libelle as libelle_f from categories c LEFT JOIN familles f on c.id_famille = f.id_famille;"));
    $societes = Societe::all();
    $sites = collect(DB::select("select s.id_site, s.id_societe,s.libelle,s.created_at, so.libelle as libelle_so from sites s LEFT JOIN societes so on s.id_societe = so.id_societe;"));
    $zones = collect(DB::select("select z.id_zone, z.libelle, z.created_at, z.id_site, s.libelle as libelle_s from zones z LEFT JOIN sites s on z.id_site=s.id_site;"));
    return view('admin.dashboard')->with(compact('users','roles','familles','categories','societes','sites','zones'));
    //  return view('admin.dashboard')->withUsers($users)->withRoles($roles);//->with('alert_info',"Hola");
  }

  public function articles(Request $request){

    $zones = collect(DB::select("select z.id_zone, z.libelle, z.created_at, z.id_site, s.libelle as libelle_s from zones z LEFT JOIN sites s on z.id_site=s.id_site limit 2;"));
    $categories = collect(DB::select("select c.id_categorie, c.id_famille, c.created_at, c.libelle as libelle, f.libelle as libelle_f from categories c LEFT JOIN familles f on c.id_famille = f.id_famille;"));
    $unites = Unite::all();
    $articles = collect(DB::select("select * from throttle"));

    $articles = Throttle::paginate($this->posts_per_page);

    if($request->ajax()) {
      return [
        'articles' => view('admin.moreData.articles')->with(compact('articles'))->render(),
        'next_page' => $articles->nextPageUrl()
      ];
    }

    return view('admin.articles')->with(compact('articles'));
  }


  public function data(Request $request)
  {
    $articles = Throttle::paginate($this->posts_per_page);

    if($request->ajax()) {
      return [
        'articles' => view('moredata')->with(compact('articles'))->render(),
        'next_page' => $articles->nextPageUrl()
      ];
    }

    return view('data')->with(compact('articles'));
  }

  public function fetchNextPostsSet($page) {
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
