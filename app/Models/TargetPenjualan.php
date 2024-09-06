<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetPenjualan extends Model
{
    use HasFactory;

    protected $table = 'target-penjualan';
    protected $guarded = [
        'created_at',
        'updated_at'
    ];
}
