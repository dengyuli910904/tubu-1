<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $table="activities";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
