<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Closure;
use Sentinel;

class AdminController extends Controller
{
  public function home(){
    return view('admin.dashboard');
  }

  //add User *******************************************************************
  public function addUser(Request $request){
    //ajouter et activer le compte de l'utilisateur
    try{
      $user = Sentinel::registerAndActivate($request->all());
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de création de l'utilisateur. Message d'erreur: ".$e->getMessage()." ");
    }
    //chercher le role pour l'utilisateur
    $role = Sentinel::findRoleBySlug($request->slug);
    //associer le role a l'utilisateur
    $role->users()->attach($user);
    return redirect()->back()->with('alert_success',"Création du l'utilisateur réussie");
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
