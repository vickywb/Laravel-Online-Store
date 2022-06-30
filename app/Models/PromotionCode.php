<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    use HasFactory;

    const TYPE_MAP = [
        'percentage' => 'PERCENTAGE',
        'fixed' => 'FIXED'
    ];

    protected $fillable = [
        'name', 'code', 'type', 'amount'
    ];
}
