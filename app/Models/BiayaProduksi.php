<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaProduksi extends Model
{
    protected $table = 'biaya_produksi';

    protected $fillable = [
        'nama_biaya_produksi',
        'jumlah_biaya_produksi',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
