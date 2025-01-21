<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaGaji extends Model
{
    protected $table = 'biaya_gaji';

    protected $fillable = [
        'nama_biaya_gaji',
        'jumlah_biaya_gaji',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
