<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'image_path',
        'excerpt',
        'body',
        'schedule',
        'starts_at',
        'is_published',
    ];

    protected $casts = [
        'schedule' => 'array',
        'starts_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
