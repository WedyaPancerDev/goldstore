<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaLainya extends Model
{
    protected $table = 'biaya_lainya';

    protected $fillable = [
        'nama_biaya_lainya',
        'jumlah_biaya_lainya',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
