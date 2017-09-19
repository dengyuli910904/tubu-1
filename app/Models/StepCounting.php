<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepCounting extends Model
{
    protected $table = 'step_counting';
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
}
