<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
  protected $table = 'zones';

  protected $primaryKey = 'id_zone';

  protected $fillable = ['id_zone', 'id_site', 'libelle',
  'created_at', 'updated_at'];
}
