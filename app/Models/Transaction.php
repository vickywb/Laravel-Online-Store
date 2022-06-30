<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_MAP = [
        'success' => 'SUCCESS',
        'shipping' => 'SHIPPING',
        'pending' => 'PENDING'
    ];

    protected $casts = [
        'date_of_transaction' => 'datetime'
    ];
    // 'datetime:Y-m-d'

    protected $fillable = [
        'user_id', 'insurance_price', 'shipping_price', 'total_price',
        'transaction_code', 'transaction_status', 'date_of_transaction',
        'promo_code', 'sub_total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}