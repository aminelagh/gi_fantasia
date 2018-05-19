<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;

class Site extends Model
{
  protected $table = 'sites';

  protected $primaryKey = 'id_site';

  protected $fillable = ['id_site','id_societe', 'libelle',
  'created_at', 'updated_at'];


  public static function getID($libelle){
    $data = collect(DB::select("SELECT id_site FROM sites where libelle like '".$libelle."' LIMIT 1;"))->first();
    if($data != null) return $data->id_site;
    else return null;
  }

  public static function addSite($libelle, $id_societe){
    $item = new Site();
    $item->id_societe = $id_societe;
    $item->libelle = $libelle;
    $item->save();
  }

  public static function updateSite($id_site, $libelle, $id_societe){
    $item = Site::find($id_site);
    $item->id_societe = $id_societe;
    $item->libelle = $libelle;
    $item->save();
  }
}
