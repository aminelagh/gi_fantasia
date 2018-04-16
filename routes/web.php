<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
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

Route::get('/b',function(){
  return view('admin.layouts.layout');
});

Route::get('/ajaxForm', 'AdminController@ajaxForm')->name('ajaxForm');
Route::post('/ajaxForm', 'AdminController@ajaxForm')->name('postAjaxForm');


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@   Administrateur-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'admin'], function () {

  Route::get('/admin', 'AdminController@home')->name('admin');

  Route::get('/more', 'AdminController@more')->name('more');

  //Unite ----------------------------------------------------------------------
  Route::get('/articles', 'AdminArticlesController@articles')->name('articles');
  Route::post('/addArticle', 'AdminArticlesController@addArticle')->name('addArticle');
  Route::post('/updateArticle', 'AdminArticlesController@updateArticle')->name('updateArticle');
  Route::post('/deleteArticle', 'AdminArticlesController@deleteArticle')->name('deleteArticle');
  Route::post('/exportArticles', 'AdminArticlesController@exportArticles')->name('exportArticles');
  Route::post('/addArticles', 'AdminArticlesController@addArticles')->name('addArticles');

  //Users ----------------------------------------------------------------------
  Route::post('/addUser', 'AdminUsersController@addUser')->name('addUser');
  Route::post('/updateUser', 'AdminUsersController@updateUser')->name('updateUser');
  Route::post('/deleteUser', 'AdminUsersController@deleteUser')->name('deleteUser');

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
Route::group(['middleware' => 'controleur'], function () {
  Route::get('/controleur', 'ControleurController@home')->name('controleur.dashboard');
});

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@   Ouvrier-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'ouvrier'], function () {
  Route::get('/controleur', 'OuvrierController@home')->name('ouvrier.dashboard');
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
