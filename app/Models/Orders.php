<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table="orders";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
