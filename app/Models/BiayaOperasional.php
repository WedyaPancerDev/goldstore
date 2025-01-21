<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaOperasional extends Model
{
    protected $table = 'biaya_operasional';

    protected $fillable = [
        'nama_biaya_operasional',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function harga_operasional()
    {
        return $this->hasMany(HargaOperasional::class);
    }
}
