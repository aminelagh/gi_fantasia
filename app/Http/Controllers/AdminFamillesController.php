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
use \App\Models\Type_intervention;
use \App\Models\Article;
use \DB;

class AdminFamillesController extends Controller
{
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //Delete Famille *************************************************************
  public function deleteFamille(Request $request){
    try{
      if(Article::where('id_famille',$request->id_famille)->get()->first()!=null){
        return redirect()->back()->with('alert_warning',"Impossible de supprimer cet élément !");
      }
      else{
        $item = Famille::find($request->id_famille);
        $item->delete();
      }
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de la famille.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Suppression de la famille réussie");
  }
  //add Famille ****************************************************************
  public function addFamille(Request $request){
    try{
      $item = new Famille();
      $item->id_categorie = $request->id_categorie;
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de création de la famille.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Création de la famille réussi");
  }
  //update Famille *************************************************************
  public function updateFamille(Request $request){
    try{
      $item = Famille::find($request->id_famille);
      $item->id_categorie = $request->id_categorie;
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de la famille.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Modification de la famille réussi");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
}
