<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups_role extends Model
{
    protected $table = 'groups_role';
    public $timestamp = true;
   	protected $casts = [
   		'id' => 'string'
   	];
}
