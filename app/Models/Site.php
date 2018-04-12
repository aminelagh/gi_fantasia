<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
  protected $table = 'sites';

  protected $primaryKey = 'id_site';

  protected $fillable = ['id_site','id_societe', 'libelle',
  'created_at', 'updated_at'];
}
