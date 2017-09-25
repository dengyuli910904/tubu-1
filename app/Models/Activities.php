<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Activities extends Model
{
    protected $table="activities";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
	public function getCreatedAtAttribute($date)
    {
         // 默认100天前输出完整时间，否则输出人性化的时间
        if (Carbon::now() > Carbon::parse($date)->addDays(100)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }
}
