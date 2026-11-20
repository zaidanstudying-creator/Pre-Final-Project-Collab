<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'synopsis',
        'cover_image',
        'status',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('chapter_number', 'asc');
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }
}
