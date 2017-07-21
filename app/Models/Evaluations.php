<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluations extends Model
{
    protected $table="evaluations";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
