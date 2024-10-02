<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignBonus extends Model
{
    use HasFactory;

    protected $table = 'assign_bonus';
    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function transaksi_pengeluaran()
    {
        return $this->belongsTo(TransaksiPengeluaran::class);
    }
    public function bonus()
    {
        return $this->belongsTo(MasterBonus::class);
    }
}
