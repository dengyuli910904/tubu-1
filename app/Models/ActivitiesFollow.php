<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitiesFollow extends Model
{
    protected $table="activities_follow";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
