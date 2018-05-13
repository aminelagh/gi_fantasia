<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use \App\Models\Article_site;

class Article extends Model
{
  protected $table = 'articles';

  protected $primaryKey = 'id_article';

  protected $fillable = ['id_article', 'id_famille', 'id_unite', 'code', 'designation',
  'created_at', 'updated_at'];

  static function getNextID(){
    $lastRecord = DB::table('articles')->orderBy('id_article', 'desc')->first();
    $result = ($lastRecord == null ? 1 : $lastRecord->id_article + 1);
    return $result;
  }

  static function exists($id_article){
    $article = Article::find($id_article);
    return $article == null ? false : true;
  }

  //add article
  static function addArticle($code, $designation, $id_unite, $id_famille, $id_site){
    $articles = Article::where('code',$code)->get();
    foreach($articles as $item){
      $id_article = $item->id_article;
      $article_sites = Article_site::where('id_article',$id_article)->get();
      foreach($article_sites as $as){
        if($as->id_site == $id_site){
          return false;
        }
      }
    }

    $id_article = Article::getNextID();
    $item = new Article();
    $item->id_article = $id_article;
    $item->id_famille = $id_famille;
    $item->id_unite = $id_unite;
    $item->code = $code;
    $item->designation = $designation;
    $item->save();

    $article_site = new Article_site();
    $article_site->id_article = $id_article;
    $article_site->id_site = $id_site;
    $article_site->save();
    return true;
  }

  //updateArticle
  static function updateArticle(Request $request){
    $articles = Article::where('code',$request->code)->get();
    foreach($articles as $item){
      $id_article = $item->id_article;
      $article_sites = Article_site::where('id_article',$id_article)->get();
      foreach($article_sites as $as){
        if($as->id_site == $request->id_site && $as->id_article != $request->id_article){
          return false;//redirect()->back()->withInput()->with('alert_warning',"ce code est déjà utilisé pour un autre article dans ce site.");
        }
      }
    }
    $item = Article::find($request->id_article);
    $item->id_famille = $request->id_famille;
    $item->id_unite = $request->id_unite;
    $item->code = $request->code;
    $item->designation = $request->designation;
    $item->save();

    $article_site = Article_site::find($request->id_article_site);
    $article_site->id_article = $request->id_article;
    $article_site->id_site = $request->id_site;
    $article_site->save();
    return true;
  }

  //updateArticle
  static function updateArticle2($id_article, $code, $designation, $id_unite, $id_famille, $id_site, $id_article_site){
    $articles = Article::where('code',$code)->get();
    foreach($articles as $item){
      $id_article = $item->id_article;
      $article_sites = Article_site::where('id_article',$id_article)->get();
      foreach($article_sites as $as){
        if($as->id_site == $id_site && $as->id_article != $id_article){
          return false;//redirect()->back()->withInput()->with('alert_warning',"ce code est déjà utilisé pour un autre article dans ce site.");
        }
      }
    }
    $item = Article::find($id_article);
    $item->id_famille = $id_famille;
    $item->id_unite = $id_unite;
    $item->code = $code;
    $item->designation = $designation;
    $item->save();

    $article_site = Article_site::find($id_article_site);
    $article_site->id_article = $id_article;
    $article_site->id_site = $id_site;
    $article_site->save();
    return true;
  }
}
