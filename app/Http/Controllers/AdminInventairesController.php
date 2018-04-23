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
    $where_id_famille = "";
    $where_id_site = "";

    if($request->has('submitFiltre')){
      //  dd($request->all());
      if($request->id_famille != 'null' ) {
        $id_famille = $request->id_famille;
        $where_id_famille = " and a.id_famille = ".$id_famille." ";
      }

      if($request->id_site != 'null' ) {
        $id_site = $request->id_site;
        $where_id_site = " and s.id_site = ".$id_site." ";
      }

      if($request->id_article != 'null' ) {
        $id_article = $request->id_article;
        $where_id_article = " and i.id_article = ".$id_article." ";
      }
    }

    /*
    $sites = collect(DB::select("SELECT s.id_site, s.libelle, s.created_at, so.libelle as libelle_societe FROM sites s LEFT JOIN societes so ON s.id_societe=so.id_societe"));
    $familles = collect(DB::select("SELECT f.id_famille, f.libelle, c.libelle as libelle_famille FROM familles f LEFT JOIN categories c on c.id_categorie = f.id_categorie;"));
    $unites = Unite::all();

    $articles = collect(DB::select(
    "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille,
    u.libelle as libelle_unite, s.libelle as libelle_site, s.id_site, article_site.id_article_site
    FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
    LEFT JOIN unites u on u.id_unite=a.id_unite
    LEFT JOIN article_site on article_site.id_article=a.id_article
    LEFT JOIN sites s on s.id_site=article_site.id_site;"
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
    ORDER BY a.code asc;"
  ));

  $zones = collect(DB::select(
    "SELECT z.id_zone, z.libelle as libelle_zone, z.id_site,
    s.libelle as libelle_site, so.libelle as libelle_societe
    FROM zones z LEFT JOIN sites s on s.id_site=z.id_site
    LEFT JOIN societes so on so.id_societe=s.id_societe;"
  ));


  $data = collect(DB::select(
    "SELECT i.id_inventaire, i.id_article, i.id_zone, i.nombre_palettes, i.nombre_pieces, i.date,
    i.created_at, i.created_by, i.updated_at, i.updated_by, i.validated_at, i.validated_by,
    a.code, a.designation, a.id_unite,
    u.libelle as libelle_unite,
    z.libelle as libelle_zone,
    us1.nom as created_by_nom, us1.prenom as created_by_prenom,
    us2.nom as updated_by_nom, us2.prenom as updated_by_prenom,
    us3.nom as validated_by_nom, us3.prenom as validated_by_prenom
    FROM inventaires i LEFT JOIN articles a ON i.id_article=a.id_article
    LEFT JOIN zones z ON i.id_zone=z.id_zone
    LEFT JOIN unites u ON u.id_unite=a.id_unite
    LEFT JOIN users us1 ON us1.id=i.created_by
    LEFT JOIN users us2 ON us2.id=i.updated_by
    LEFT JOIN users us3 ON us3.id=i.validated_by;"
  ));
/*
  dump($data);
  foreach ($data as $item) {
    dump($item);
  }
  dd(1);*/

  //the returned view
  $view = view('admin.inventaires')->with(compact('data','articles','zones'))->withTitle('Inventaire');
  if($request->has('submitFiltre')){
    if($request->has('id_famille') && $request->id_famille != "null"){
      $view->with('selected_id_famille',$request->id_famille);
    }
    if($request->has('id_site') && $request->id_site != "null" ){
      $view->with('selected_id_site',$request->id_site);
    }
  }

  return $view;

  //$articles = Throttle::paginate($this->posts_per_page);
  if($request->ajax()) {
    return [
      'articles' => view('admin.moreData.articles')->with(compact('articles'))->render(),
      'next_page' => $articles->nextPageUrl()
    ];
  }
  //return view('admin.articles')->with(compact('articles','sites','unites','familles'));
}


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//add Inventaire *************************************************************
public function addInventaire(Request $request){
  try{
    //$id_article = Article::getNextID();

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
public function deleteArticle(Request $request){
  try{
    $item = Article::find($request->id_article);
    $item->delete();
    $article_site = Article_site::find($request->id_article_site);
    $article_site->delete();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de suppression de l'article.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Article supprimé");
}
//update Article *************************************************************
public function updateArticle(Request $request){
  try{

    $item = Article::find($request->id_article);
    $item->id_famille = $request->id_famille;
    $item->id_unite = $request->id_unite;
    $item->code = $request->code;
    $item->designation = $request->designation;
    $item->save();

    $article_site = Article_site::find($request->id_article_site);
    $article_site->id_article = $request->id_article;
    $article_site->id_site = $request->id_site;
    $article_site->save();

  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de modification de l'article.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Article modifié");
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

public function exportArticles(Request $request){
  try{

    $where_id_famille = "";
    $where_id_site = "";

    if($request->id_famille != 'null' ) {
      $id_famille = $request->id_famille;
      $where_id_famille = " and a.id_famille ".$id_famille." ";
    }

    if($request->id_site != 'null' ) {
      $id_site = $request->id_site;
      $where_id_site = " and s.id_site = ".$id_site." ";
    }
    $GLOBALS['where_id_famille'] = $where_id_famille;
    $GLOBALS['where_id_site'] = $where_id_site;

    Excel::create('Articles', function($excel) {
      $excel->sheet('Articles', function($sheet) {

        $where_id_famille = $GLOBALS['where_id_famille'];
        $where_id_site = $GLOBALS['where_id_site'];

        $articles = collect(DB::select(
          "SELECT a.id_article, a.id_famille, a.id_unite, a.code, a.designation, a.created_at, f.libelle as libelle_famille,
          u.libelle as libelle_unite, s.libelle as libelle_site, s.id_site, article_site.id_article_site
          FROM articles a LEFT JOIN familles f on f.id_famille=a.id_famille
          LEFT JOIN unites u on u.id_unite=a.id_unite
          LEFT JOIN article_site on article_site.id_article=a.id_article
          LEFT JOIN sites s on s.id_site=article_site.id_site
          WHERE true " . $where_id_famille . " ".$where_id_site." ;"
        ));

        $sheet->appendRow(array("id_article","code_article","designation_article","id_famille","Famille","id_unite","unite","date de création"));
        foreach ($articles as $item) {
          $sheet->appendRow(array( $item->id_article,$item->code,$item->designation,$item->id_famille,$item->libelle_famille,$item->id_unite,$item->libelle_unite,$item->created_at));
        }

        /*$sheet->appendRow(array("id_article","Code","Designation","id_famille","Famille","id_article_site","id_site","Site","id_unite","Unité","date de création"));
        foreach ($articles as $item) {
        $sheet->appendRow(array( $item->id_article,$item->code,$item->designation,$item->id_famille,$item->libelle_famille,$item->id_article_site,$item->id_site,$item->libelle_site,$item->id_unite,$item->libelle_unite,$item->created_at));
      }*/
    });
  })->export('xls');

}catch(Exception $e){
  return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
}
}

public function addArticles(Request $request){
  $file = $request->file('file');
  if($file->getClientOriginalExtension() != "xls"){
    return redirect()->back()->with('alert_warning',"Veuillez importer un fichier excel.");
  }
  /*
  //Display File Name
  echo 'File Name: '.$file->getClientOriginalName();
  //Display File Extension
  echo 'File Extension: '.$file->getClientOriginalExtension();
  //Display File Real Path
  echo 'File Real Path: '.$file->getRealPath();
  //Display File Size
  echo 'File Size: '.$file->getSize();
  //Display File Mime Type
  echo 'File Mime Type: '.$file->getMimeType();*/

  //Move Uploaded File
  $destinationPath = 'uploads';
  $file->move($destinationPath,$file->getClientOriginalName());

  Excel::load('uploads/'.$file->getClientOriginalName(), function($reader) {
    //Excel::selectSheetsByIndex(0)->load();
    //$x = $reader->get(array("id_article","Code","Famille","Site","Designation","Unité","date de creation"));
    //dump($x);
  });
  try{

    Excel::load('uploads/'.$file->getClientOriginalName())->chunk(1000000, function($results)
    {
      $i = 2;
      foreach($results as $row){
        try{
          if(!is_numeric($row->id_article) || !is_numeric($row->id_famille) || !is_numeric($row->id_unite)){
            throw new Exception("Erreur dans la ligne: ".$i);
          }

          echo "Article: ".$row->id_article." - ".$row->code_article." - ".$row->designation_article."<br>";
          echo "Unite: ".$row->id_unite." - ".$row->unite."<br>";
          echo "Famille: ".$row->id_famille." - ".$row->famille."<hr>";

        }catch(Exception $e){
          return redirect()->back()->with('alert_danger',"erreur d'importation des articles, veuillez vérifier la validité du document chargé.<br>Message d'erreur: ".$e->getMessage());
        }

        //$this->saveArticle($row->id_article, $row->id_famille, $row->id_unite, $row->code, $row->designation);
        //$this->saveFamille($row->id_famille, $row->famille);
        //$this->saveUnite($row->id_unite, $row->unite);
        //$this->saveArticleSite($row->id_article_site, $row->id_article, $row->id_site);
      }
    });
  }catch(Exception $e){
    //return redirect()->back()->with('alert_danger',"erreur d'importation des articles, veuillez vérifier la validité du document chargé.<br>Message d'erreur: ".$e->getMessage());
  }
  //return redirect()->back()->with('alert_success',"Chargement des articles réussi");
}

public static function saveArticle($id_article, $id_famille, $id_unite, $code, $designation){
  $item = Article::find($id_article);
  if($item == null){
    $item = new Article();
    $item->id_article = $id_article;
  }
  $item->id_famille = $id_famille;
  $item->id_unite = $id_unite;
  $item->code = $code;
  $item->designation = $designation;
  $item->save();
}
public static function saveUnite($id_unite, $libelle_unite){
  $item = Unite::find($id_unite);
  if($item == null){
    $item = new Unite();
    $item->id_unite = $id_unite;
  }
  $item->libelle = $libelle_unite;
  $item->save();
}
public static function saveFamille($id_famille, $libelle_famille){
  $item = Famille::find($id_famille);
  if($item == null){
    $item = new Famille();
    $item->id_famille = $id_famille;
  }
  $item->libelle = $libelle_famille;
  $item->save();
}

public static function saveArticleSite($id_article_site, $id_article, $id_site){
  $item = Article_site::find($id_article_site);
  if($item == null){
    $item = new Article_site();
    $item->id_article_site = $id_article_site;
  }
  $item->id_article = $id_article;
  $item->id_site = $id_site;
  $item->save();
}
}
