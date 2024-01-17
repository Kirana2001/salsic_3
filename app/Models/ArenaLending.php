<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArenaLending extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function arena()
    {
        return $this->belongsTo('App\Models\Arena', 'arena_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\LendingStatus', 'status_id', 'id');
    }
}
