<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';

    protected $fillable = [
        'nama_cabang',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function transaksiPengeluaran()
    {
        return $this->hasMany(TransaksiPengeluaran::class);
    }
}
