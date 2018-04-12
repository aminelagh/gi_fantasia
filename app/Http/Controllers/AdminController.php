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
use \DB;

class AdminController extends Controller
{
  public function home(){
    //dd(Role_user::all());
    try{
      //$role_user = Role_user::where('user_id', 4)->delete();
    }  catch(Exception $e) {dd($e->getMessage()); }

    $users = collect(DB::select("select u.id as id_user,u.nom, u.prenom,r.slug,r.name,u.last_login,u.created_at,u.login from users u LEFT JOIN role_users ru on ru.user_id = u.id LEFT JOIN roles r on r.id = ru.role_id;"));
    $roles = Role::all();
    $familles = Famille::all();
    //$categories = Categorie::all();
    $categories = collect(DB::select("select c.id_categorie, c.id_famille, c.created_at, c.libelle as libelle, f.libelle as libelle_f from categories c LEFT JOIN familles f on c.id_famille = f.id_famille;"));
    return view('admin.dashboard')->with(['users'=>$users, 'roles'=>$roles,'familles'=>$familles, 'categories'=>$categories]);
    //  return view('admin.dashboard')->withUsers($users)->withRoles($roles);//->with('alert_info',"Hola");
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
