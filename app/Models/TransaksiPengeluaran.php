<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'transaksi-pengeluaran';

    protected $guarded = [
        "created_at",
        "updated_at"
    ];
}
