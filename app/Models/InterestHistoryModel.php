<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'interest_history';
    protected $primaryKey = 'id';

    protected $fillable = [
        'investment_id',
        'plan_id',
        'amount',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
