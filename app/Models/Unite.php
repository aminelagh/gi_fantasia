<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;

class Unite extends Model
{
  protected $table = 'unites';

  protected $primaryKey = 'id_unite';

  protected $fillable = ['id_unite', 'libelle',
  'created_at', 'updated_at'];

  public static function getID($libelle){
    $data = collect(DB::select("SELECT id_unite FROM unites where libelle like '".$libelle."' LIMIT 1;"))->first();
    if($data != null) return $data->id_unite;
    else return null;
  }

}
