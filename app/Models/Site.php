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
}
