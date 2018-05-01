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
use \App\Models\Article_site;
use \App\Models\Inventaire;
use \DB;

class ControleurController extends Controller
{
  //liste inventaires pas encore valide
  public function home(Request $request){
    $where_id_zone = "";
    $where_id_article = "";
    if($request->has('submitFiltre')){
      if($request->id_zone != 'null' ) {$where_id_zone = " and z.id_zone = ".$request->id_zone." ";}
      if($request->id_article_site != 'null' ) {$where_id_article = " and i.id_article = ".Article_site::find($request->id_article_site)->id_article." ";}
    }

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
      WHERE sa.id_site = ".Session::get('id_site')."
      ORDER BY a.code asc;"
    ));

    $title = "Inventaires valide";

    //inventaires query
    $data = collect(DB::select(
      "SELECT i.id_inventaire, i.id_article, i.id_zone, i.nombre_palettes, i.nombre_pieces,i.longueur, i.largeur, i.hauteur, i.date,
      i.created_at, i.created_by, i.updated_at, i.updated_by, i.validated_at, i.validated_by,
      a.code, a.designation, a.id_unite,
      ars.id_article_site,
      u.libelle as libelle_unite,
      z.libelle as libelle_zone,
      us1.nom as created_by_nom, us1.prenom as created_by_prenom,
      us2.nom as updated_by_nom, us2.prenom as updated_by_prenom,
      us3.nom as validated_by_nom, us3.prenom as validated_by_prenom
      FROM inventaires i LEFT JOIN articles a ON i.id_article=a.id_article
      LEFT JOIN article_site ars ON ars.id_article=i.id_article AND ars.id_site=(select id_site from zones where zones.id_zone=i.id_zone)
      LEFT JOIN zones z ON i.id_zone=z.id_zone
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      LEFT JOIN users us1 ON us1.id=i.created_by
      LEFT JOIN users us2 ON us2.id=i.updated_by
      LEFT JOIN users us3 ON us3.id=i.validated_by
      WHERE i.id_zone = ".Session::get('id_zone')." AND validated_by is null " . $where_id_article . " ".$where_id_zone." ;"
    ));

    //the returned view
    $view = view('controleur.dashboard')->with(compact('data','articles','title'));

    //if filter return selected_items
    if($request->has('submitFiltre')){
      if($request->has('id_zone') && $request->id_zone != "null"){$view->with('selected_id_zone',$request->id_zone);}
      if($request->has('id_article_site') && $request->id_article_site != "null" ){$view->with('selected_id_article_site',$request->id_article_site);}
    }

    return $view;
  }

  public function inventairesValide(Request $request){
    $where_date = "";
    $where_id_article = "";
    if($request->has('submitFiltre')){
      if($request->date != 'null' ) {$where_date = " AND i.date LIKE '".$request->date."' ";}
      if($request->id_article_site != 'null' ) {$where_id_article = " AND i.id_article = ".Article_site::find($request->id_article_site)->id_article." ";}
    }

    $articles = collect(DB::select(
      "SELECT sa.*,
      a.code, a.designation, a.id_famille, a.id_unite,
      u.libelle as libelle_unite,    s.libelle as libelle_site,    so.libelle as libelle_societe,    f.libelle as libelle_famille
      FROM article_site sa LEFT JOIN articles a on a.id_article=sa.id_article
      LEFT JOIN sites s on s.id_site=sa.id_site
      LEFT JOIN societes so on so.id_societe=s.id_societe
      LEFT JOIN unites u on u.id_unite=a.id_unite
      LEFT JOIN familles f on f.id_famille=a.id_famille
      WHERE sa.id_site = ".Session::get('id_site')." ORDER BY a.code asc;"
    ));

    $title = "Inventaires valide";

    //inventaires query
    $data = collect(DB::select(
      "SELECT i.id_inventaire, i.id_article, i.id_zone, i.nombre_palettes, i.nombre_pieces,i.longueur, i.largeur, i.hauteur, i.date,
      i.created_at, i.created_by, i.updated_at, i.updated_by, i.validated_at, i.validated_by,
      a.code, a.designation, a.id_unite,
      ars.id_article_site,
      u.libelle as libelle_unite,
      z.libelle as libelle_zone,
      us1.nom as created_by_nom, us1.prenom as created_by_prenom,
      us2.nom as updated_by_nom, us2.prenom as updated_by_prenom,
      us3.nom as validated_by_nom, us3.prenom as validated_by_prenom
      FROM inventaires i LEFT JOIN articles a ON i.id_article=a.id_article
      LEFT JOIN article_site ars ON ars.id_article=i.id_article AND ars.id_site=(select id_site from zones where zones.id_zone=i.id_zone)
      LEFT JOIN zones z ON i.id_zone=z.id_zone
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      LEFT JOIN users us1 ON us1.id=i.created_by
      LEFT JOIN users us2 ON us2.id=i.updated_by
      LEFT JOIN users us3 ON us3.id=i.validated_by
      WHERE i.id_zone = ".Session::get('id_zone')." AND validated_by is not null " . $where_id_article . " ".$where_date." ;"
    ));
    //the returned view
    $view = view('controleur.inventairesValide')->with(compact('data','articles','title'));

    //if filter return selected_items
    if($request->has('submitFiltre')){
      if($request->has('date') && $request->date != "null"){$view->with('selected_date',$request->date);}
      if($request->has('id_article_site') && $request->id_article_site != "null" ){$view->with('selected_id_article_site',$request->id_article_site);}
    }

    return $view;
  }

  public function home2(Request $request){

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

    /*  $articles = collect(DB::select(
    "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille,
    u.libelle as libelle_unite, s.libelle as libelle_site, s.id_site, article_site.id_article_site
    FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
    LEFT JOIN unites u on u.id_unite=a.id_unite
    LEFT JOIN article_site on article_site.id_article=a.id_article
    LEFT JOIN sites s on s.id_site=article_site.id_site
    WHERE true " . $where_id_famille . " ".$where_id_site." ;"
  ));*/

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

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//add Inventaire *************************************************************
public function addInventaire(Request $request){
  try{
    $item = new Inventaire();
    $item->id_article = Article_site::find($request->id_article_site)->id_article;
    $item->id_zone = Session::get('id_zone');
    $item->date = $request->date;

    $item->nombre_palettes = $request->nombre_palettes;
    $item->nombre_pieces = $request->nombre_pieces;
    $item->hauteur = $request->hauteur;
    $item->largeur = $request->largeur;
    $item->longueur = $request->longueur;

    $item->created_by = Session::get('id_user');
    $item->updated_by = null;
    $item->validated_by = Session::get('id_user');
    //$item->created_at = null;
    //$item->updated_at = null;
    $item->validated_at = date('Y-m-d H:i:s');
    $item->save();

  }catch(Exception $e){
    return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de l'inventaire.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Inventaire créé");
}
//Delete Article *************************************************************
public function deleteInventaire(Request $request){
  try{
    $item = Inventaire::find($request->id_inventaire);
    $item->delete();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de suppression de l'inventaire.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Inventaire supprimé");
}
//update Article *************************************************************
public function updateInventaire(Request $request){
  try{
    $item = Inventaire::find($request->id_inventaire);
    $item->id_article = Article_site::find($request->id_article_site)->id_article;
    $item->id_zone = $request->session()->get('id_zone');
    $item->date = $request->date;
    $item->nombre_palettes = $request->nombre_palettes;
    $item->nombre_pieces = $request->nombre_pieces;
    $item->longueur = $request->longueur;
    $item->largeur = $request->largeur;
    $item->hauteur = $request->hauteur;
    //$item->created_by = $request->session()->get('id_user');
    $item->updated_by = $request->session()->get('id_user');
    $item->validated_by = $request->session()->get('id_user');

    //$item->created_at = null;
    //$item->updated_at = null;
    $item->validated_at = date('Y-m-d H:i:s');
    $item->save();

  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de modification de l'inventaire.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Inventaire modifié");
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//update Profil **************************************************************
public function updateProfil(Request $request){
  try{
    $item = User::find($request->id);
    $item->nom = $request->nom;
    $item->prenom = $request->prenom;
    $item->login = $request->login;
    if( $request->password != "" ){
      $item->password = password_hash($request->password, PASSWORD_DEFAULT);
    }
    $item->save();
    $this->updateSession();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de modification de votre profile.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Modification du profile réussi");
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
