<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table="groupmember";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
