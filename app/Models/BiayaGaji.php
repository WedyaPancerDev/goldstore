<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaGaji extends Model
{
    protected $table = 'biaya_gaji';

    protected $fillable = [
        'user_id',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hargaGaji()
    {
        return $this->hasMany(HargaGaji::class);
    }
}
