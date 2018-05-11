<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;

class Famille extends Model
{
  protected $table = 'familles';

  protected $primaryKey = 'id_famille';

  protected $fillable = ['id_famille', 'id_categorie', 'libelle',
  'created_at', 'updated_at'];


  public static function getID($libelle_famille){
    $data = collect(DB::select("SELECT id_famille FROM familles where libelle like '".$libelle_famille."' LIMIT 1;"))->first();
    if($data != null) return $data->id_famille;
    else return null;
  }
}
