<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitiesCollect extends Model
{
    protected $table = 'activities_collect';
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
