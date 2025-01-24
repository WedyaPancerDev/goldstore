<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaProduksi extends Model
{
    protected $table = 'harga_produksi';

    protected $fillable = [
        'biaya_produksi_id',
        'harga',
        'bulan',
        'tahun',
        'is_deleted',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function biayaProduksi()
    {
        return $this->belongsTo(BiayaProduksi::class);
    }
}
