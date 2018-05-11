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
use \App\Models\Session as Sessions;
use \DB;

class ControleurController extends Controller
{
  //liste inventaires pas encore valide
  public function home(Request $request){

    //valider les inventaires
    if($request->has('submitValidate')){
      if(!$request->has('id_inventaire')){
        return redirect()->back()->with('alert_info',"Veuillez filtrer les inventaires avant de les valider.");
      }
      $inventaires = $request->id_inventaire;
      $valides = $request->valide;
      $i = 1;
      foreach($inventaires as $inv){
        $item = Inventaire::find($inv);
        if(isset($valides[$inv]) && $valides[$inv] == "isValide"){
          $item->validated_by = Session::get('id_user');
          $item->validated_at = date('Y-m-d H:i:s');
        }else{
          $item->validated_by = null;
          $item->validated_at = null;
        }
        $i++;
        $item->save();
      }
    }
    //-----------------------------

    // on submit Filter --------------------
    if($request->has('submitFiltre') || $request->has('submitValidate')){
      $whereSession = "";
      $whereSite = "";
      $whereZone = "";
      $whereArticle = "";

      if($request->id_session != 'null')       {$whereSession = " AND i.id_session = ".$request->id_session." ";}
      if($request->id_site != 'null')          {$whereSite = " AND i.id_zone in (select id_zone from zones where id_site = ".$request->id_site.") ";}
      if($request->id_zone != 'null')          {$whereZone = " AND z.id_zone = ".$request->id_zone." ";}
      if($request->code != 'null')             {$whereArticle = " AND i.id_article in (SELECT id_article FROM articles WHERE code like '".$request->code."') ";}

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
        FROM inventaires i
        LEFT JOIN articles a ON i.id_article=a.id_article
        LEFT JOIN article_site ars ON ars.id_article=i.id_article AND ars.id_site=(select id_site from zones where zones.id_zone=i.id_zone)
        LEFT JOIN sites s ON s.id_site=ars.id_site
        LEFT JOIN zones z ON i.id_zone=z.id_zone
        LEFT JOIN unites u ON u.id_unite=a.id_unite
        LEFT JOIN users us1 ON us1.id=i.created_by
        LEFT JOIN users us2 ON us2.id=i.updated_by
        LEFT JOIN users us3 ON us3.id=i.validated_by
        WHERE i.id_zone in (SELECT id_zone FROM zones WHERE id_site in (SELECT id_site FROM sites WHERE id_societe=".Session::get('id_societe')."))
        " . $whereSession . " " . $whereSite . " " . $whereZone . " " . $whereArticle . " ;"
      ));
    }
    else{
      $data = null;
    }

    //get data for forms --------------------
    $articles = collect(DB::select(
      "SELECT sa.*,
      a.code, a.designation, a.id_famille, a.id_unite,
      u.libelle as libelle_unite,
      s.libelle as libelle_site,
      so.libelle as libelle_societe,
      f.libelle as libelle_famille
      FROM article_site sa
      LEFT JOIN articles a on a.id_article=sa.id_article
      LEFT JOIN sites s on s.id_site=sa.id_site
      LEFT JOIN societes so on so.id_societe=s.id_societe
      LEFT JOIN unites u on u.id_unite=a.id_unite
      LEFT JOIN familles f on f.id_famille=a.id_famille
      WHERE so.id_societe = ".Session::get('id_societe')."
      ORDER BY a.code asc;"
    ));
    $filtreArticles = collect(DB::select(
      "SELECT DISTINCT code from articles a;"
    ));
    $sessions = Sessions::all();
    $session = Sessions::find(Sessions::getNextID());
    $sites = Site::where('id_societe',Session('id_societe'))->get();
    $categories = Categorie::all();
    $familles = Famille::all();
    $zones = collect(DB::select(
      "SELECT z.id_zone, z.libelle as libelle_zone, z.id_site,
      s.libelle as libelle_site, so.libelle as libelle_societe
      FROM zones z LEFT JOIN sites s on s.id_site=z.id_site
      LEFT JOIN societes so on so.id_societe=s.id_societe
      WHERE so.id_societe = ".Session::get('id_societe').";"
    ));
    $title = "Inventaires";
    //--------------------------------------------------

    //the returned view
    $view = view('controleur.dashboard')->with(compact('data','articles','title','sessions','sites','zones','categories','familles','session','filtreArticles'));

    //if filter return selected_items
    if($request->has('submitFiltre')){
      if($request->has('id_session') && $request->id_session != "null"){$view->with('selected_id_session',$request->id_session);}
      if($request->has('id_site') && $request->id_site != "null"){$view->with('selected_id_site',$request->id_site);}
      if($request->has('id_zone') && $request->id_zone != "null"){$view->with('selected_id_zone',$request->id_zone);}
      if($request->has('code') && $request->code != "null" ){$view->with('selected_code',$request->code);}
    }
    if($request->has('submitValidate')){
      if($request->has('id_session') && $request->id_session != "null"){$view->with('selected_id_session',$request->id_session);}
      if($request->has('id_site') && $request->id_site != "null"){$view->with('selected_id_site',$request->id_site);}
      if($request->has('id_zone') && $request->id_zone != "null"){$view->with('selected_id_zone',$request->id_zone);}
      if($request->has('code') && $request->code != "null" ){$view->with('selected_code',$request->code);}
    }

    return $view;
  }


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//add Inventaire *************************************************************
public function addInventaire(Request $request){
  try{
    $item = new Inventaire();
    $item->id_article = Article_site::find($request->id_article_site)->id_article;
    $item->id_zone = $request->id_zone;
    $item->id_session = Sessions::getNextID();
    $item->date = $request->date;
    $item->nombre_palettes = $request->nombre_palettes;
    $item->nombre_pieces = $request->nombre_pieces;

    $item->hauteur = $request->hauteur;
    $item->largeur = $request->largeur;
    $item->longueur = $request->longueur;
    $item->created_by = $request->session()->get('id_user');
    $item->updated_by = null;
    $item->validated_by = null;
    //$item->created_at = null;
    //$item->updated_at = null;
    $item->validated_at = null;
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
    //$item->id_article = Article_site::find($request->id_article_site)->id_article;
    //$item->id_zone = $request->id_zone;
    $item->date = $request->date;
    $item->nombre_palettes = $request->nombre_palettes;
    $item->nombre_pieces = $request->nombre_pieces;
    $item->longueur = $request->longueur;
    $item->largeur = $request->largeur;
    $item->hauteur = $request->hauteur;
    //$item->created_by = $request->session()->get('id_user');
    $item->updated_by = $request->session()->get('id_user');
    //$item->validated_by = $request->session()->get('id_user');

    //$item->created_at = null;
    //$item->updated_at = null;
    //$item->validated_at = date('Y-m-d H:i:s');
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
