<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verifycode extends Model
{
    protected $table="verifycode";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
