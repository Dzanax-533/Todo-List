<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_completed',
    ];

    /**
     * The tags that belong to the task.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Scope a query to filter by tag name or slug.
     */
    public function scopeWithTag($query, $tag)
    {
        if (! $tag) {
            return $query;
        }

        return $query->whereHas('tags', function ($q) use ($tag) {
            $q->where('name', $tag)->orWhere('slug', $tag);
        });
    }
}
