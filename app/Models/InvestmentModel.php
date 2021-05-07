<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentModel extends Model
{
    use HasFactory;

    protected $table = 'investment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'plan_id',
        'user_id',
        'amount',
        'attachment',
        'investment_id',
        'type',
        'is_cooldown',
        'is_lock',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
