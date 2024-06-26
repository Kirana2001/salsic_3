<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemuda extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function cabor()
    {
        return $this->belongsTo('App\Models\Cabor', 'cabor_id', 'id');
    }

    public function bidang()
    {
        return $this->belongsTo('App\Models\Bidang');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\VerificationStatus', 'status_id', 'id');
    }

    public function anggota()
    {
        return $this->hasMany('App\Models\Anggota');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
