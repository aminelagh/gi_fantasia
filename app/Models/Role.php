<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'roles';
	//protected $primaryKey = 'id_famille';
	protected $fillable = ['id','slug','name','permissions', 'created_at', 'updated_at' ];
}
