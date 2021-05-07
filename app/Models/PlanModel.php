<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanModel extends Model
{
    use HasFactory;

    protected $table = 'plan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'amount',
        'percentage',
        'months_term',
        'months_lockin',
        'months_cooldown',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
