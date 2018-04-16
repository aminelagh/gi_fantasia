<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article_site extends Model
{
  protected $table = 'article_site';

  protected $primaryKey = 'id_article_site';

  protected $fillable = ['id_article_site', 'id_article', 'id_site',
  'created_at', 'updated_at'];
}
