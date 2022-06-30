<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'file_id'
    ];

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function getFileUrlAttribute()
    {
        if (empty($this->file_id)) {
            return null;
        }

        return Storage::url($this->file->location);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
