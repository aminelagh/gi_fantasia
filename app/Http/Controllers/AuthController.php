<?php

namespace App\Http\Controllers;

use \Exception;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Session;
use Sentinel;
use DB;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\Role_user;

class AuthController extends Controller
{
  //login *****************************************************************************
  public function login(){
    try {
      DB::connection()->getPdo();
    } catch (Exception $e) {
      return view('login')->with('alert_danger',"Problème de connexion avec la base de données. Veuillez réessayer plus tard.");
    }

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
        if( Sentinel::inRole('ouvrier') ){
          $zone = collect(DB::select("SELECT * FROM zones WHERE id_zone=". $user->id_zone .";"))->first();
          $site = collect(DB::select("SELECT * FROM sites WHERE id_site in (SELECT id_site FROM zones z WHERE id_zone=". $user->id_zone .");"))->first();
          $societe = collect(DB::select("SELECT * FROM societes WHERE id_societe in (SELECT id_societe FROM sites WHERE id_societe=".$site->id_societe.");"))->first();
          Session::put('id_zone', $user->id_zone);
          Session::put('libelle_zone', $zone->libelle);

          Session::put('id_site', $site->id_site);
          Session::put('libelle_site', $site->libelle);

          Session::put('id_societe', $societe->id_societe);
          Session::put('libelle_societe', $societe->libelle);
        }
        else if( Sentinel::inRole('controleur') ){
          $societe = collect(DB::select("SELECT * FROM societes WHERE id_societe=".$user->id_societe." ;"))->first();
          Session::put('id_societe', $societe->id_societe);
          Session::put('libelle_societe', $societe->libelle);
        }
        return $this->redirectToSpace();
      } else {
        return redirect()->back()->withInput()->with("alert_warning","<b>login et/ou mot de passe incorrect</b>");
      }
    } catch (ThrottlingException $e) {
      return redirect()->back()->withInput()->with("alert_warning", "<b>Une activité suspecte s'est produite sur votre adresse IP, l'accès vous est refusé pour " . $e->getDelay() . " seconde (s)</b>")->withTimerDanger($e->getDelay() * 1000);
    }
    catch (Exception $e) {
      return redirect()->route('login')->withInput()->with("alert_danger", "Erreur !<br>Code de l'erreur:  ".$e->getCode()." ");
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
