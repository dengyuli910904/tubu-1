<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities_sign extends Model
{
    protected $table = 'activities_sign';
    public $timestamp = true;
   	protected $casts = [
   		'id' => 'string'
   	];
}
