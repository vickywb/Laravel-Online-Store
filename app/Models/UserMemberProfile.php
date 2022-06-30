<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UserMemberProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'file_id', 'category_id', 'address', 'address2',
        'phone_number', 'country', 'provinces_id', 'regencies_id', 'post_code',
        'store_name', 'store_status',
    ];

    public function profile()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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

    public function province()
    {
        return $this->hasOne(Province::class, 'id', 'provinces_id');
    }

    public function regency()
    {
        return $this->hasOne(Regency::class, 'id', 'regencies_id');
    }
}
