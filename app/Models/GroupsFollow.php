<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupsFollow extends Model
{
    protected $table="groups_follow";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
