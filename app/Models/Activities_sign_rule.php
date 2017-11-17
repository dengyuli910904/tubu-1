<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities_sign_rule extends Model
{
    protected $table = 'activities_sign_rule';
    public $timestamp = true;
   	protected $casts = [
   		'id' => 'string'
   	];
}
