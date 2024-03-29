<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelatih extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pelatih';

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function cabor()
    {
        return $this->belongsTo('App\Models\Cabor', 'cabor_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\VerificationStatus', 'status_id', 'id');
    }
}
