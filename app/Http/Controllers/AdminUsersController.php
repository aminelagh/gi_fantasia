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
use \App\Models\Type_intervention;
use \App\Models\Equipement;
use \DB;

class AdminUsersController extends Controller
{

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

  //update User ****************************************************************
  public function updateUser(Request $request){
    //dd($request->all());
    try{
      $item = User::find($request->id);
      $item->nom = $request->nom;
      $item->prenom = $request->prenom;
      $item->login = $request->login;
      if( $request->password != "" ){
        $item->password = password_hash($request->password, PASSWORD_DEFAULT);
      }
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de l'utilisateur.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Modification de l'utilisateur réussi");
  }

  //Delete User ****************************************************************
  public function deleteUser(Request $request){
    try{
      if($request->id == 1){
        return redirect()->back()->with("alert_warning","Impossible de supprimer l'administrateur principal");
      }
      $item = User::find($request->id);
      $item->delete();
      //$role_user = Role_user::where('user_id', $request->id)->get()->first();
      //$role_user->delete();
      $role_user = Role_user::where('user_id', $request->id)->delete();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'utilisateur.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Suppression de l'utilisateur réussie");
  }
}
