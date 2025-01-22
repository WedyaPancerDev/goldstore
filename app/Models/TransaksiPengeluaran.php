<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pengeluaran';

    protected $fillable = [
        'nomor_order',
        'order_date',
        'quantity',
        'total_price',
        'deskripsi',
        'produk_id',
        'user_id',
        'cabang_id',
    ];

    protected $guarded = [
        "created_at",
        "updated_at"
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
