<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityMember extends Model
{
    protected $table="activitymembers";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
