<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups_role_user extends Model
{
    protected $table = 'groups_role_user';
    public $timestamp = true;
   	protected $casts = [
   		'id' => 'string'
   	];
}
