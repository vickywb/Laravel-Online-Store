<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'location'
    ];

    //accessor
    public function getFileUrlAttribute()
    {
        return Storage::url($this->location);
    }

    //relationship
    public function userMemberProfiles()
    {
        $this->hasMany(UserMemberProfile::class);
    }

    public function products() 
    {
        $this->hasMany(Product::class);
    }

    public function categories() 
    {
        $this->hasMany(Category::class);
    }
    
    public function sliders() 
    {
        $this->hasMany(Slider::class);
    }

    public function productImages()
    {
        $this->hasMany(ProductImage::class);
    }
}
