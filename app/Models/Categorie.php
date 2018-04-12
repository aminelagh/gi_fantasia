<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
  protected $table = 'categories';

  protected $primaryKey = 'id_categorie';

  protected $fillable = ['id_categorie', 'id_famille', 'libelle',
  'created_at', 'updated_at'];
}
