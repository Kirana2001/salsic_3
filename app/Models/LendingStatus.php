<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LendingStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lending_status';

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
