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
use \DB;

class AdminSocietesController extends Controller
{
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //Delete Societe *************************************************************
  public function deleteSociete(Request $request){
    try{
      if(Site::where('id_societe',$request->id_societe)->get()->first()!=null){
        return redirect()->back()->with('alert_warning',"Impossible de supprimer cet élément !");
      }
      else{
        $item = Societe::find($request->id_societe);
        $item->delete();
      }
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de la société.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Société supprimée");
  }
  //add Societe ****************************************************************
  public function addSociete(Request $request){
    try{
      $item = new Societe();
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de création de la société.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Société créée");
  }
  //update Societe *************************************************************
  public function updateSociete(Request $request){
    try{
      $item = Societe::find($request->id_societe);
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de la société.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Société modifiée");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
}
