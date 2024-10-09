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

    protected $fillable = [
        'user_id',
        'transaksi_pengeluaran_id',
        'bonus_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function transaksi_pengeluaran()
    {
        return $this->belongsTo(TransaksiPengeluaran::class, 'transaksi_pengeluaran_id');
    }
    
    public function bonus()
    {
        return $this->belongsTo(MasterBonus::class, 'bonus_id');
    }
}
