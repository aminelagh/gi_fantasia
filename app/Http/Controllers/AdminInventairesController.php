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
use \App\Models\Article_site;
use \App\Models\Article;
use \App\Models\Unite;
use \App\Models\Inventaire;
use \DB;
use Excel;

class AdminInventairesController extends Controller
{
  public function inventaires(Request $request){

    $where_id_zone = "";
    $where_id_article = "";
    if($request->has('submitFiltre')){
      if($request->id_zone != 'null' ) {
        $id_zone = $request->id_zone;
        $where_id_zone = " and z.id_zone = ".$id_zone." ";
      }

      if($request->id_article_site != 'null' ) {
        $id_article = Article_site::find($request->id_article_site)->id_article;
        $where_id_article = " and i.id_article = ".$id_article." ";
      }
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
      ORDER BY a.code asc;"
    ));

    $title = "Inventaires";
    $categories = collect(DB::select(
      "SELECT * FROM categories c;"
    ));

    $zones = collect(DB::select(
      "SELECT z.id_zone, z.libelle as libelle_zone, z.id_site,
      s.libelle as libelle_site, so.libelle as libelle_societe
      FROM zones z LEFT JOIN sites s on s.id_site=z.id_site
      LEFT JOIN societes so on so.id_societe=s.id_societe;"
    ));

    $familles = collect(DB::select(
      "SELECT * FROM familles;"
    ));

    //inventaires query
    $data = collect(DB::select(
      "SELECT i.id_inventaire, i.id_article, i.id_zone, i.nombre_palettes, i.nombre_pieces, i.date,
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
      WHERE true " . $where_id_article . " ".$where_id_zone." ;"
    ));

    //the returned view
    $view = view('admin.inventaires')->with(compact('data','articles','zones','categories','familles','categories'));

    //if filter return selected_items
    if($request->has('submitFiltre')){
      if($request->has('id_zone') && $request->id_zone != "null"){
        $view->with('selected_id_zone',$request->id_zone);
      }
      if($request->has('id_article_site') && $request->id_article_site != "null" ){
        $view->with('selected_id_article_site',$request->id_article_site);
      }
    }

    return $view;


    $articles = Throttle::paginate($this->posts_per_page);
    if($request->ajax()) {
      //dump("aaaaaaaaaaaaaaaaaaaaaaa");
      //return 'bbb';
      $familles = collect(DB::select(
        "SELECT * FROM familles where id_famille = 1;"
      ));
      return [
        'familles' => view('admin.inventaires')->with(compact('familles'))->render()
        //'next_page' => $articles->nextPageUrl()
      ];
    }
    //return view('admin.articles')->with(compact('articles','sites','unites','familles'));

  }


  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //add Inventaire *************************************************************
  public function addInventaire(Request $request){
    try{
      $item = new Inventaire();
      $item->id_article = Article_site::find($request->id_article_site)->id_article;
      $item->id_zone = $request->id_zone;
      $item->date = $request->date;
      $item->nombre_palettes = $request->nombre_palettes;
      $item->nombre_pieces = $request->nombre_pieces;
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
      $item->id_article = Article_site::find($request->id_article_site)->id_article;
      $item->id_zone = $request->id_zone;
      $item->date = $request->date;
      $item->nombre_palettes = $request->nombre_palettes;
      $item->nombre_pieces = $request->nombre_pieces;
      //$item->created_by = $request->session()->get('id_user');
      $item->updated_by = $request->session()->get('id_user');;
      //$item->validated_by = null;
      //$item->created_at = null;
      //$item->updated_at = null;
      //$item->validated_at = null;
      $item->save();

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de l'inventaire.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Inventaire modifié");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

  public function exportInventaires(Request $request){
    try{

      $where_id_zone = "";
      $where_id_article = "";

      if($request->id_zone != 'null' ) {
        $id_zone = $request->id_zone;
        $where_id_zone = " and z.id_zone = ".$id_zone." ";
      }

      if($request->id_article_site != 'null' ) {
        $id_article = Article_site::find($request->id_article_site)->id_article;
        $where_id_article = " and i.id_article = ".$id_article." ";
      }

      $GLOBALS['where_id_zone'] = $where_id_zone;
      $GLOBALS['where_id_article'] = $where_id_article;

      Excel::create('Inventaire', function($excel) {
        $excel->sheet('Inventaire', function($sheet) {

          $where_id_zone = $GLOBALS['where_id_zone'];
          $where_id_article = $GLOBALS['where_id_article'];

          //inventaires query
          $data = collect(DB::select(
            "SELECT i.id_inventaire, i.id_article, i.id_zone, i.nombre_palettes, i.nombre_pieces, i.date,
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
            WHERE true " . $where_id_article . " ".$where_id_zone." ;
            "));

            $sheet->appendRow(array("code article","Article","Zone","date","Nombre plettes","Quantié", "Nombre pieces","Cree par","le","Modifié par","le","validé par","le"));
            foreach ($data as $item) {
              $sheet->appendRow(array($item->code, $item->designation, $item->libelle_zone,
              $item->date, $item->nombre_palettes, $item->nombre_pieces,
              $item->nombre_palettes*$item->nombre_pieces." ".$item->libelle_unite,
              $item->created_by_nom .' '. $item->created_by_prenom, $item->created_at,
              $item->updated_by_nom .' '. $item->updated_by_prenom, $item->updated_at,
              $item->validated_by_nom .' '. $item->validated_by_prenom, $item->validated_at
            ));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }



}