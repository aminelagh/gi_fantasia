<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
  protected $table = 'inventaires';

  protected $primaryKey = 'id_inventaire';

  protected $fillable = ['id_inventaire', 'id_article_site',
  'nombre_palettes','nombre_pieces', 'hauteur','largeur','longueur', 'date',
  'created_by', 'updated_by', 'validated_by',
  'created_at', 'updated_at', 'validated_at'];
}
