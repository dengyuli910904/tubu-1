<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities_role_apply extends Model
{
    protected $table = 'activities_role_apply';
    public $timestamp = true;
   	protected $casts =[
   		'id' => 'string'
   	];
}
