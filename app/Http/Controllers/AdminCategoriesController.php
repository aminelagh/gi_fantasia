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
use \DB;

class AdminCategoriesController extends Controller
{

  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //Delete Categorie *************************************************************
  public function deleteCategorie(Request $request){
    try{
      $item = Categorie::find($request->id_categorie);
      $item->delete();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de la categorie.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Categorie supprimée");
  }
  //add Categorie ****************************************************************
  public function addCategorie(Request $request){
    try{
      $item = new Categorie();
      $item->id_famille = $request->id_famille;
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de création de la Categorie.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Categorie créée");
  }
  //update Categorie *************************************************************
  public function updateCategorie(Request $request){
    try{
      $item = Categorie::find($request->id_categorie);
      $item->id_famille = $request->id_famille;
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de la categorie.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Categorie modifiée");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
}
