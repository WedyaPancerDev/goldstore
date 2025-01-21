<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaOperasional extends Model
{
    protected $table = 'harga_operasional';

    protected $fillable = [
        'biaya_operasional_id',
        'harga',
        'bulan',
        'tahun',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function biaya_operasional()
    {
        return $this->belongsTo(BiayaOperasional::class);
    }
}
