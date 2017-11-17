<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities_role extends Model
{
    protected $table = 'activities_role';
    public $timestamp = true;
   	protected $casts = [
   		'id' => 'string'
   	];
}
