<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    //table categories ---------------------------------------------------------
    Schema::create('categories', function (Blueprint $table) {
      $table->increments('id_categorie');
      $table->string('libelle',200)->unique();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    //table familles -----------------------------------------------------------
    Schema::create('familles', function (Blueprint $table) {
      $table->increments('id_famille');
      $table->integer('id_categorie');
      $table->string('libelle',255);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    //--------------------------------------------------------------------------

    //table societes -----------------------------------------------------------
    Schema::create('societes', function (Blueprint $table) {
      $table->increments('id_societe');
      $table->string('libelle',200)->unique();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    //table sites --------------------------------------------------------------
    Schema::create('sites', function (Blueprint $table) {
      $table->increments('id_site');
      $table->integer('id_societe');
      $table->string('libelle',255);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    //table zones --------------------------------------------------------------
    Schema::create('zones', function (Blueprint $table) {
      $table->increments('id_zone');
      $table->integer('id_site');
      $table->string('libelle',255);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    //--------------------------------------------------------------------------

    //table unites -------------------------------------------------------------
    Schema::create('unites', function (Blueprint $table) {
      $table->increments('id_unite');
      $table->string('libelle',200)->unique();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    //table article_site -------------------------------------------------------
    Schema::create('article_site', function (Blueprint $table) {
      $table->increments('id_article_site');
      $table->integer('id_article');
      $table->integer('id_site');
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    //table articles -----------------------------------------------------------
    Schema::create('articles', function (Blueprint $table) {
      $table->increments('id_article');
      $table->integer('id_famille');
      $table->integer('id_unite');
      $table->string('code',255);
      $table->string('designation',255);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
    //--------------------------------------------------------------------------

    //table inventaires --------------------------------------------------------
    Schema::create('inventaires', function (Blueprint $table) {
      $table->increments('id_inventaire');
      $table->integer('id_article');
      $table->integer('id_zone');
      $table->integer('nombre_palettes');
      $table->integer('nombre_pieces');
      $table->datetime('date');

      $table->integer('created_by');
      $table->integer('updated_by');
      $table->integer('validated_by');

      $table->timestamps();
      $table->datetime('validated_at');
      $table->engine = 'InnoDB';
    });

    //table articles
    Schema::create('inventaires_backup', function (Blueprint $table) {
      $table->increments('id_inventaire');
      $table->integer('id_article_site');
      $table->integer('id_zone');
      $table->integer('nombre_palettes');
      $table->integer('nombre_pieces');
      $table->datetime('date');

      $table->integer('created_by');
      $table->integer('updated_by');
      $table->integer('validated_by');

      $table->timestamps();
      $table->datetime('validated_at');
      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('familles');
    Schema::dropIfExists('categories');
    Schema::dropIfExists('societes');
    Schema::dropIfExists('sites');
    Schema::dropIfExists('zones');
    Schema::dropIfExists('unites');
    Schema::dropIfExists('articles');
    Schema::dropIfExists('article_site');
    Schema::dropIfExists('inventaires');
    Schema::dropIfExists('inventaires_backup');
  }
}
