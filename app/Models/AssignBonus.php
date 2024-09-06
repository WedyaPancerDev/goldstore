<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignBonus extends Model
{
    use HasFactory;

    protected $table = 'assign-bonus';
    protected $guarded = [
        'created_at',
        'updated_at'
    ];
}
