<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article_site extends Model
{
  protected $table = 'article_site';

  protected $primaryKey = 'id_article_site';

  protected $fillable = ['id_article_site', 'id_article', 'id_site',
  'created_at', 'updated_at'];


  static function getIdArticle($id_article_site)
  {
    $lastRecord = DB::table('article_site')->where('id_article_site', $id_article_site )->get()->first();
    $result = ($lastRecord == null ? 1 : $lastRecord->id_article + 1);
    return $result;
  }
}
