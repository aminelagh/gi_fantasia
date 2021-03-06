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
use \App\Models\Session as Sessions;
use \DB;

class AdminController extends Controller
{
  protected $posts_per_page = 10;

  public function home(Request $request){

    $users = collect(DB::select("SELECT u.id as id_user,u.nom, u.prenom,r.slug,r.name,u.last_login,u.created_at,u.login,u.id_zone, u.id_societe from users u LEFT JOIN role_users ru on ru.user_id = u.id LEFT JOIN roles r on r.id = ru.role_id;"));
    $roles = Role::all();
    $categories = Categorie::all();
    $familles = collect(DB::select(
      "SELECT f.libelle, f.id_famille, f.id_categorie, f.created_at, c.libelle as libelle_categorie from familles f LEFT JOIN categories c on c.id_categorie = f.id_categorie;"
    ));
    $sessions = collect(DB::select(
      "SELECT s.id_session, date_debut, date_fin, s.created_at,  count(id_inventaire) as nombre_inventaires
      FROM sessions s LEFT JOIN inventaires i on s.id_session=i.id_session
      GROUP BY s.id_session;"
    ));
    //foreach ($sessions as $item) dump($item);dd($sessions);
    $societes = Societe::all();
    $sites = collect(DB::select("select s.id_site, s.id_societe,s.libelle,s.created_at, so.libelle as libelle_so from sites s LEFT JOIN societes so on s.id_societe = so.id_societe;"));
    $zones = collect(DB::select("select z.id_zone, z.libelle, z.created_at, z.id_site, s.libelle as libelle_s from zones z LEFT JOIN sites s on z.id_site=s.id_site;"));

    $unites = Unite::all();
    return view('admin.dashboard')->with(compact('users','roles','familles','categories','societes','sites','zones','unites','sessions'));
    //  return view('admin.dashboard')->withUsers($users)->withRoles($roles);//->with('alert_info',"Hola");
  }

  public function createNewSession(Request $request){
    try{
      Sessions::splitSession();

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de création de la nouvelle session.<br>Message d'erreur: ".$e->getMessage());
    }
    return redirect()->back()->with('alert_success',"Création de session réussie");
  }


  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //add Session *************************************************************
  public function addSessions(Request $request){
    try{
      if( $request->date_debut >  $request->date_fin)
      return redirect()->back()->withInput()->with('alert_warning',"La date fin est inférieur la date de début");

      $item = new Sessions();
      $item->date_debut = $request->date_debut;
      $item->date_fin = $request->date_fin;
      $item->save();

    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de la session.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Session créée");
  }
  //Delete Session *************************************************************
  public function deleteSessions(Request $request){
    try{
      if( $request->date_debut >  $request->date_fin)
      return redirect()->back()->withInput()->with('alert_warning',"La date fin est inférieur la date de début");

      $item = Sessions::find($request->id_session);
      //$item->delete();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de la session.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Session supprimée");
  }
  //update Session *************************************************************
  public function updateSessions(Request $request){
    try{
      if( $request->date_debut >  $request->date_fin)
      return redirect()->back()->withInput()->with('alert_warning',"La date fin est inférieur la date de début");

      $item = Sessions::find($request->id_session);
      $item->date_debut = $request->date_debut;
      $item->date_fin = $request->date_fin;
      $item->save();

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de la session.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Session modifiée");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

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


  public function ajaxForm(Request $request){
    //$articles = Throttle::paginate($this->posts_per_page);

    if($request->ajax()) {
      echo "Nom: ".$request->nom."<br>";
      echo "Prenom: ".$request->prenom;

      $vals = array(
        'alert_info'     => "Done",
      );
      echo json_encode($vals);
      /*  return [
      'articles' => view('admin.moreData.articles')->with(compact('articles'))->render(),
      'next_page' => $articles->nextPageUrl()
    ];*/
  }
  else if($request->has('submit')){
    echo "Nom: ".$request->nom."<br>";
    echo "Prenom: ".$request->prenom;
    //return view('ajaxForm')->with('alert_info',"Doone");
    //dump($request->all());
  }
  else
  return view('ajaxForm');
}
}
