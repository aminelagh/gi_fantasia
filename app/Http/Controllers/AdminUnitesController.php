<?php

namespace App\Http\Controllers;

use Closure;
use \Exception;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\User;
use \App\Models\Article;
use \App\Models\Famille;
use \App\Models\Categorie;
use \App\Models\Societe;
use \App\Models\Site;
use \App\Models\Unite;
use \DB;


class AdminUnitesController extends Controller
{
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //Delete Unite *************************************************************
  public function deleteUnite(Request $request){
    try{
      if(Article::where('id_unite',$request->id_unite)->get()->first()!=null){
        return redirect()->back()->with('alert_warning',"Impossible de supprimer cet élément !");
      }
      else{
        $item = Unite::find($request->id_unite);
        $item->delete();
      }

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'unité.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Unité supprimée");
  }
  //add Unite ****************************************************************
  public function addUnite(Request $request){
    try{
      $item = new Unite();
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de création de l'unité.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Unité créée");
  }
  //update Unite *************************************************************
  public function updateUnite(Request $request){
    try{
      $item = Unite::find($request->id_unite);
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de l'unité.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Unité modifiée");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
}
