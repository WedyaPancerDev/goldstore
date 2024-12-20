<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
