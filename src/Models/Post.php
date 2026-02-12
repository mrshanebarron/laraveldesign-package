<?php

namespace MrShaneBarron\LaravelDesign\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'ld_posts';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'blocks',
        'editor_mode',
        'builder_data',
        'featured_image',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'parent_id',
        'order',
        'template',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'blocks' => 'array',
        'builder_data' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    // Relationships
    public function author(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')->orderBy('order');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'ld_category_post', 'post_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'ld_post_tag', 'post_id', 'tag_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
            ->where('published_at', '>', now());
    }

    public function scopePosts($query)
    {
        return $query->where('type', 'post');
    }

    public function scopePages($query)
    {
        return $query->where('type', 'page');
    }

    public function scopeRootPages($query)
    {
        return $query->whereNull('parent_id');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        if ($this->type === 'page') {
            return url($this->slug);
        }

        return url('blog/' . $this->slug);
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        return max(1, ceil($words / 200));
    }

    // Methods
    public function publish(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    public function usesBuilder(): bool
    {
        return $this->editor_mode === 'builder' && !empty($this->blocks);
    }

    public function getRenderedContentAttribute(): string
    {
        if ($this->usesBuilder()) {
            return $this->renderBlocks();
        }

        return $this->content ?? '';
    }

    public function renderBlocks(): string
    {
        if (empty($this->blocks)) {
            return '';
        }

        $html = '';
        foreach ($this->blocks as $block) {
            $html .= \MrShaneBarron\LaravelDesign\Services\BlockRenderer::render($block);
        }

        return $html;
    }
}
