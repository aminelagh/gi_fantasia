<?php

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
use \App\Models\Session as Sessions;
use Carbon\Carbon;


Route::get('/', function () {
  /*
  $lastRecord = DB::table('sessions')->orderBy('id_session', 'desc')->first();
  dump($lastRecord);

  $debut = Carbon::createFromFormat('Y-m-d', $lastRecord->date_debut);
  $fin = Carbon::createFromFormat('Y-m-d', $lastRecord->date_fin);
  $date = Carbon::now();

  dump($debut->dayOfWeek );
  dump($date->dayOfWeek );
  dump($fin->dayOfWeek );

  $now = Carbon::now();
  $startOfWeek = $now->copy()->startOfWeek();
  $endOfWeek = $now->copy()->endOfWeek();*/

  //return $result;

  /*$credentials = [
  'login'    => 'admin',
  'password' => '123456',
  'nom' => 'Laghlabi',
  'prenom' => 'Amine',
];

$user = Sentinel::registerAndActivate($credentials);

$role = Sentinel::findRoleBySlug('admin');
$role->users()->attach($user);*/


return view('welcome');
});

Route::get('/s',function(){
  dd(Session::all());
});


Route::get('/ajaxForm', 'AdminController@ajaxForm')->name('ajaxForm');
Route::post('/ajaxForm', 'AdminController@ajaxForm')->name('postAjaxForm');


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@   Administrateur-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'admin'], function () {
  Route::get('/admin', 'AdminController@home')->name('admin');
  //Route::get('/more', 'AdminController@more')->name('more');

  //articles -------------------------------------------------------------------
  Route::get('/articles', 'AdminArticlesController@articles')->name('articles');
  Route::post('/articles', 'AdminArticlesController@articles')->name('articles');
  Route::post('/addArticle', 'AdminArticlesController@addArticle')->name('addArticle');
  Route::post('/updateArticle', 'AdminArticlesController@updateArticle')->name('updateArticle');
  Route::post('/deleteArticle', 'AdminArticlesController@deleteArticle')->name('deleteArticle');
  Route::post('/exportArticles', 'AdminArticlesController@exportArticles')->name('exportArticles');
  Route::post('/addArticles', 'AdminArticlesController@addArticles')->name('addArticles');

  //Inventaire -----------------------------------------------------------------
  Route::get('/inventaires', 'AdminInventairesController@inventaires')->name('inventaires');
  Route::post('/inventaires', 'AdminInventairesController@inventaires')->name('inventaires');
  Route::post('/addInventaire', 'AdminInventairesController@addInventaire')->name('addInventaire');
  Route::post('/updateInventaire', 'AdminInventairesController@updateInventaire')->name('updateInventaire');
  Route::post('/deleteInventaire', 'AdminInventairesController@deleteInventaire')->name('deleteInventaire');
  Route::post('/exportInventaires', 'AdminInventairesController@exportInventaires')->name('exportInventaires');
  Route::post('/addInventaires', 'AdminInventairesController@addInventaires')->name('addInventaires');

  //Users ----------------------------------------------------------------------
  Route::post('/addUser', 'AdminUsersController@addUser')->name('addUser');
  Route::post('/updateUser', 'AdminUsersController@updateUser')->name('updateUser');
  Route::post('/deleteUser', 'AdminUsersController@deleteUser')->name('deleteUser');
  Route::post('/updateProfil', 'AdminUsersController@updateProfil')->name('updateProfil');

  //Familles -------------------------------------------------------------------
  Route::post('/addFamille', 'AdminFamillesController@addFamille')->name('addFamille');
  Route::post('/updateFamille', 'AdminFamillesController@updateFamille')->name('updateFamille');
  Route::post('/deleteFamille', 'AdminFamillesController@deleteFamille')->name('deleteFamille');

  //Categorie ------------------------------------------------------------------
  Route::post('/addCategorie', 'AdminCategoriesController@addCategorie')->name('addCategorie');
  Route::post('/updateCategorie', 'AdminCategoriesController@updateCategorie')->name('updateCategorie');
  Route::post('/deleteCategorie', 'AdminCategoriesController@deleteCategorie')->name('deleteCategorie');

  //Societe --------------------------------------------------------------------
  Route::post('/addSociete', 'AdminSocietesController@addSociete')->name('addSociete');
  Route::post('/updateSociete', 'AdminSocietesController@updateSociete')->name('updateSociete');
  Route::post('/deleteSociete', 'AdminSocietesController@deleteSociete')->name('deleteSociete');

  //Site -----------------------------------------------------------------------
  Route::post('/addSite', 'AdminSitesController@addSite')->name('addSite');
  Route::post('/updateSite', 'AdminSitesController@updateSite')->name('updateSite');
  Route::post('/deleteSite', 'AdminSitesController@deleteSite')->name('deleteSite');

  //Zone -----------------------------------------------------------------------
  Route::post('/addZone', 'AdminZonesController@addZone')->name('addZone');
  Route::post('/updateZone', 'AdminZonesController@updateZone')->name('updateZone');
  Route::post('/deleteZone', 'AdminZonesController@deleteZone')->name('deleteZone');

  //Unite ----------------------------------------------------------------------
  Route::post('/addUnite', 'AdminUnitesController@addUnite')->name('addUnite');
  Route::post('/updateUnite', 'AdminUnitesController@updateUnite')->name('updateUnite');
  Route::post('/deleteUnite', 'AdminUnitesController@deleteUnite')->name('deleteUnite');

});

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@   Controleur-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'controleur','prefix' => 'c'], function () {
  Route::get('/', 'ControleurController@home')->name('controleur');
  Route::post('/', 'ControleurController@home')->name('controleur');

  Route::post('/updateProfil', 'ControleurController@updateProfil')->name('c.updateProfil');

  //Inventaire -----------------------------------------------------------------
  Route::get('/inventairesValide', 'ControleurController@inventairesValide')->name('c.inventairesValide');
  Route::post('/inventairesValide', 'ControleurController@inventairesValide')->name('c.inventairesValide');

  Route::get('/inventaires', 'ControleurController@inventaires')->name('c.inventaires');
  Route::post('/inventaires', 'ControleurController@inventaires')->name('c.inventaires');
  Route::post('/addInventaire', 'ControleurController@addInventaire')->name('c.addInventaire');
  Route::post('/updateInventaire', 'ControleurController@updateInventaire')->name('c.updateInventaire');
  Route::post('/deleteInventaire', 'ControleurController@deleteInventaire')->name('c.deleteInventaire');
  Route::post('/exportInventaires', 'ControleurController@exportInventaires')->name('c.exportInventaires');
  Route::post('/addInventaires', 'ControleurController@addInventaires')->name('c.addInventaires');

  //Articles -------------------------------------------------------------------
  Route::get('/articles', 'ControleurArticlesController@articles')->name('c.articles');
  Route::post('/articles', 'ControleurArticlesController@articles')->name('c.articles');
  Route::post('/addArticle', 'ControleurArticlesController@addArticle')->name('c.addArticle');
  Route::post('/updateArticle', 'ControleurArticlesController@updateArticle')->name('c.updateArticle');
  Route::post('/deleteArticle', 'ControleurArticlesController@deleteArticle')->name('c.deleteArticle');
  Route::post('/exportArticles', 'ControleurArticlesController@exportArticles')->name('c.exportArticles');
  Route::post('/addArticles', 'ControleurArticlesController@addArticles')->name('c.addArticles');

  //Familles -------------------------------------------------------------------
  Route::post('/addFamille', 'AdminFamillesController@addFamille')->name('c.addFamille');
  Route::post('/updateFamille', 'AdminFamillesController@updateFamille')->name('c.updateFamille');
  Route::post('/deleteFamille', 'AdminFamillesController@deleteFamille')->name('c.deleteFamille');

  //Categorie ------------------------------------------------------------------
  Route::post('/addCategorie', 'AdminCategoriesController@addCategorie')->name('c.addCategorie');
  Route::post('/updateCategorie', 'AdminCategoriesController@updateCategorie')->name('c.updateCategorie');
  Route::post('/deleteCategorie', 'AdminCategoriesController@deleteCategorie')->name('c.deleteCategorie');

  //Societe --------------------------------------------------------------------
  Route::post('/addSociete', 'AdminSocietesController@addSociete')->name('c.addSociete');
  Route::post('/updateSociete', 'AdminSocietesController@updateSociete')->name('c.updateSociete');
  Route::post('/deleteSociete', 'AdminSocietesController@deleteSociete')->name('c.deleteSociete');

  //Site -----------------------------------------------------------------------
  Route::post('/addSite', 'AdminSitesController@addSite')->name('c.addSite');
  Route::post('/updateSite', 'AdminSitesController@updateSite')->name('c.updateSite');
  Route::post('/deleteSite', 'AdminSitesController@deleteSite')->name('c.deleteSite');

  //Zone -----------------------------------------------------------------------
  Route::post('/addZone', 'AdminZonesController@addZone')->name('c.addZone');
  Route::post('/updateZone', 'AdminZonesController@updateZone')->name('c.updateZone');
  Route::post('/deleteZone', 'AdminZonesController@deleteZone')->name('c.deleteZone');
});

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@   Ouvrier-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'ouvrier', 'prefix' => 'o'], function () {
  Route::get('/', 'OuvrierController@home')->name('ouvrier');
  Route::post('/', 'OuvrierController@home')->name('ouvrier');
  Route::post('/updateProfil', 'OuvrierController@updateProfil')->name('o.updateProfil');

  //Inventaire -----------------------------------------------------------------
  //Route::get('/inventaires', 'OuvrierInventairesController@inventaires')->name('o.inventaires');
  Route::post('/inventaires', 'OuvrierController@inventaires')->name('o.inventaires');
  Route::post('/addInventaire', 'OuvrierController@addInventaire')->name('o.addInventaire');
  Route::post('/updateInventaire', 'OuvrierController@updateInventaire')->name('o.updateInventaire');
  Route::post('/deleteInventaire', 'OuvrierController@deleteInventaire')->name('o.deleteInventaire');
  Route::post('/exportInventaires', 'OuvrierController@exportInventaires')->name('o.exportInventaires');
  Route::post('/addInventaires', 'OuvrierController@addInventaires')->name('o.addInventaires');

});



//Authentification
//login
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@submitLogin')->name('submitLogin');

//logout
Route::get('/logout', 'AuthController@logout')->name('logout');

//error Routes
Route::get('{any}', function () {
  return redirect()->back()->with('alert_warning',"Oups !<br>il paraît que vous avez pris le mauvais chemin");
});
