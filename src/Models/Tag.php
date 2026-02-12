<?php

namespace MrShaneBarron\LaravelDesign\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $table = 'ld_tags';

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    // Relationships
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'ld_post_tag', 'tag_id', 'post_id');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return url('tag/' . $this->slug);
    }

    public function getPostsCountAttribute(): int
    {
        return $this->posts()->published()->count();
    }
}
