<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
  protected $table = 'societes';

  protected $primaryKey = 'id_societe';

  protected $fillable = ['id_societe', 'libelle',
  'created_at', 'updated_at'];
}
