<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaGaji extends Model
{
    protected $table = 'harga_gaji';

    protected $fillable = [
        'user_id',
        'harga',
        'bulan',
        'tahun',
        'is_deleted'
    ];

    protected $guarded = [
        'created_at',
        'updated_at'
    ];
}
