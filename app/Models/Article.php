<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Article extends Model
{
  protected $table = 'articles';

  protected $primaryKey = 'id_article';

  protected $fillable = ['id_article', 'id_famille', 'id_unite', 'code', 'designation',
  'created_at', 'updated_at'];

  static function getNextID()
  {
    $lastRecord = DB::table('articles')->orderBy('id_article', 'desc')->first();
    $result = ($lastRecord == null ? 1 : $lastRecord->id_article + 1);
    return $result;
  }
}
