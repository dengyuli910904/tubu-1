<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupsApply extends Model
{
    protected $table="groupsapply";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
