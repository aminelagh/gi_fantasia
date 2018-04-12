<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
  protected $table = 'inventaires';

  protected $primaryKey = 'id_inventaire';

  protected $fillable = ['id_inventaire', 'id_article', 'id_zone', 'nombre_palettes','nombre_pieces', 'date',
  'created_by', 'updated_by', 'validated_by',
  'created_at', 'updated_at', 'validated_at'];
}
