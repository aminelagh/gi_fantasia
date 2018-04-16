<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
  protected $table = 'familles';

  protected $primaryKey = 'id_famille';

  protected $fillable = ['id_famille', 'id_categorie', 'libelle',
  'created_at', 'updated_at'];
}
