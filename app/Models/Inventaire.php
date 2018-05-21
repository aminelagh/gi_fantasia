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

  public static function addInventaire($id_article_site,$id_session,$id_zone, $date, $palettes,$pieces,$longueur,$largeur,$hauteur, $created_by,$updated_by,$validated_by, $created_at,$updatd_at,$validated_at){
    $item = new Inventaire();
    $item->id_article_site = $id_article_site;
    $item->id_session = $id_session;
    $item->id_zone = $id_zone;
    $item->date = $date;
    $item->nombre_palettes = $palettes;
    $item->nombre_pieces = $pieces;

    $item->longueur = $longueur;
    $item->largeur = $largeur;
    $item->hauteur = $hauteur;

    $item->created_by = $created_by;
    $item->updated_by = $updated_by;
    $item->validated_by = $validated_by;
    //$item->created_at = null;
    //$item->updated_at = null;
    $item->validated_at = $validated_at;
    $item->save();
  }

  public static function updateInventaire($id_inventaire,$id_article_site,$id_session,$id_zone, $date, $palettes,$pieces,$longueur,$largeur,$hauteur, $created_by,$updated_by,$validated_by, $created_at,$updatd_at,$validated_at){
    $item = Inventaire::find($id_inventaire);
    $item->id_article_site = $id_article_site;
    $item->id_session = $id_session;
    $item->id_zone = $id_zone;
    $item->date = $date;
    $item->nombre_palettes = $palettes;
    $item->nombre_pieces = $pieces;

    $item->longueur = $longueur;
    $item->largeur = $largeur;
    $item->hauteur = $hauteur;

    $item->created_by = $created_by;
    $item->updated_by = $updated_by;
    $item->validated_by = $validated_by;
    //$item->created_at = null;
    //$item->updated_at = null;
    $item->validated_at = $validated_at;
    $item->save();
  }
}
