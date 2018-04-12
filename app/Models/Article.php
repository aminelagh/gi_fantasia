<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
  protected $table = 'articles';

  protected $primaryKey = 'id_article';

  protected $fillable = ['id_article', 'id_categorie', 'id_zone', 'id_unite', 'code', 'designation',
  'created_at', 'updated_at'];

}
