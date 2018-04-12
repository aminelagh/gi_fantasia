<?php

namespace App\Http\Controllers;

use \Exception;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\Role_user;

class AuthController extends Controller
{
  //login *****************************************************************************
  public function login(){
    if( Sentinel::check() ){
      return self::redirectToSpace();
    }
    else{
      return view('login');
    }
  }

  //Authentification ******************************************************************
  public function submitLogin(Request $request){
    try {
      $user = Sentinel::authenticate(request()->all());
      if (Sentinel::check()) {
        Session::put('id_user', $user->id);
        Session::put('role', $this->getRole());
        Session::put('login', $user->login);
        Session::put('nom', $user->nom);
        Session::put('prenom', $user->prenom);
        //dd($request->session()->all());
        return $this->redirectToSpace();
      } else {
        return redirect()->back()->withInput()->with("alert_warning","<b>login et/ou mot de passe incorrect</b>");
      }
    } catch (ThrottlingException $e) {
      return redirect()->back()->withInput()->with("alert_warning", "<b>Une activité suspecte s'est produite sur votre adresse IP, l'accès vous est refusé pour " . $e->getDelay() . " seconde (s)</b>")->withTimerDanger($e->getDelay() * 1000);
    }
    catch (Exception $e) {
      return redirect()->route('login')->withInput()->with("alert_danger", "Erreur !<br>Message d'erreur:  ".$e->getMessage()." ");
    }
  }


  //Deconnexion ***********************************************************************
  public function logout(){
    try{
      Sentinel::logout();
      Session::flush();
      return redirect('/');
    }
    catch (Exception $e) {
      return redirect()->back()->withInput()->with('alert_danger', "Erreur !<br>Message d'erreur:  ".$e->getMessage()."");
    }
  }

  //redirect to proper dashboard ******************************************************
  private static function redirectToSpace(){
    if( Sentinel::inRole('admin') ){
      return redirect()->route('admin');
    }elseif( Sentinel::inRole('controleur') ){
      return redirect()->route('controleur');
    }elseif( Sentinel::inRole('ouvrier') ){
      return redirect()->route('ouvrier');
    }else{
      return redirect()->route('errorPage')->with("alert_danger","Le rôle de l'utilisateur authentifié n'est pas répertorié, veuillez contacter l'administrateur de l'application.");
    }
  }

  //return role of the current users **************************************************
  public function getRole()
  {
    if (Sentinel::inRole('admin')){
      return "admin";
    }
    elseif(Sentinel::inRole('controleur')){
      return "controleur";
    }
    elseif(Sentinel::inRole('ouvrier')){
      return "ouvrier";
    }
  }
}
