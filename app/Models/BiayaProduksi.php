<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaProduksi extends Model
{
    protected $table = 'biaya_produksi';

    protected $fillable = [
        'nama_biaya_produksi',
        'is_deleted',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function hargaProduksi()
    {
        return $this->hasMany(HargaProduksi::class);
    }
}
