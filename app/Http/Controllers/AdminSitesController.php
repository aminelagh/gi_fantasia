<?php

namespace App\Http\Controllers;

use Closure;
use \Exception;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\User;
use \App\Models\Article_site;
use \App\Models\Famille;
use \App\Models\Categorie;
use \App\Models\Societe;
use \App\Models\Site;
use \App\Models\Zone;
use \DB;

class AdminSitesController extends Controller
{

  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //Delete Site *************************************************************
  public function deleteSite(Request $request){
    try{
      if(Zone::where('id_site',$request->id_site)->get()->first()!=null || Article_site::where('id_site',$request->id_site)->get()->first()!=null){
        return redirect()->back()->with('alert_warning',"Élément utilisé ailleurs, donc impossible de le supprimer");
      }
      else{
        $item = Site::find($request->id_site);
        $item->delete();
      }

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression du site.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Site supprimé");
  }
  //add Site ****************************************************************
  public function addSite(Request $request){
    try{
      $item = new Site();
      $item->id_societe = $request->id_societe;
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de création du site.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Site créé");
  }
  //update Site *************************************************************
  public function updateSite(Request $request){
    try{
      $item = Site::find($request->id_site);
      $item->id_societe = $request->id_societe;
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification du site.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Site modifié");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
}
