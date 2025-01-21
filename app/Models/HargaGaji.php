<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaGaji extends Model
{
    protected $table = 'harga_gaji';

    protected $fillable = [
        'biaya_gaji_id',
        'harga',
        'bulan',
        'tahun',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function biayaGaji()
    {
        return $this->belongsTo(BiayaGaji::class);
    }
}
