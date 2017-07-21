<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Replaies extends Model
{
    protected $table="replaies";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
