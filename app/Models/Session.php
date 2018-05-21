<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Session extends Model{

  protected $table = 'sessions';
  protected $primaryKey = 'id_session';
  protected $fillable = ['id_session','date_debut','date_fin','created_at', 'updated_at' ];

  public static function getNextID(){
    $lastRecord = DB::table('sessions')->orderBy('id_session', 'desc')->first();
    $date = Carbon::today();
    $debut = Carbon::createFromFormat('Y-m-d', $lastRecord->date_debut);
    $fin = Carbon::createFromFormat('Y-m-d', $lastRecord->date_fin);
    if($date->gt($debut) && $date->lte($fin)){
      return $lastRecord->id_session;
    }
    else{
      $now = Carbon::now();
      $debut = $now->copy();
      $now->addDays(10);
      $fin = $now->copy();

      $item = new Session();
      $item->date_debut = $debut;
      $item->date_fin = $fin;
      $item->save();

      return DB::table('sessions')->orderBy('id_session', 'desc')->first()->id_session;
    }
  }

  public static function getNextID2(){
    $lastRecord = DB::table('sessions')->orderBy('id_session', 'desc')->first();

    $debut = Carbon::createFromFormat('Y-m-d', $lastRecord->date_debut);
    $fin = Carbon::createFromFormat('Y-m-d', $lastRecord->date_fin);
    $date = Carbon::now();

    if($debut < $date && $date < $fin ){
      return $lastRecord->id_session;
    }
    else{
      $now = Carbon::now();
      $startOfWeek = $now->copy()->startOfWeek();
      $endOfWeek = $now->copy()->endOfWeek();
      $item = new Session();
      $item->date_debut = $startOfWeek;
      $item->date_fin = $endOfWeek;
      $item->save();
      return $lastRecord->id_session + 1;
    }
  }

  public static function splitSession(){

    $now = Carbon::now();
    $endOfWeek = $now->copy()->endOfWeek();

    $currentSession = Session::find(Session::getNextID());
    $currentSession->date_fin = $now;
    $currentSession->save();

    $item = new Session();
    $item->date_debut = $now;
    $item->date_fin = $endOfWeek;
    $item->save();
  }
}
