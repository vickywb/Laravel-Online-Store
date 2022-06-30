<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'product_name',
        'slug', 'price', 'description', 'quantity'
    ];

    public function getFileUrlAttribute()
    {
        if (empty($this->file_id)) {
            return null;
        }

        return Storage::url($this->file->location);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    //accessor
    public function getFirstImageAttribute()
    {
        return $this->productImages()->first();
    }
}
