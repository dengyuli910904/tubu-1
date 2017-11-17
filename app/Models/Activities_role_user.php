<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities_role_user extends Model
{
    protected $table = 'activities_role_user';
    public $timestamp = true;
   	protected $casts = [
   		'id' => 'string'
   	];
}
