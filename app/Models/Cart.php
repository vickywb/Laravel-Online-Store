<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'product_id'
    ];

    //relationship
    public function user() 
    {
       return $this->belongsTo(User::class);
    }

    public function product()
    {
       return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
