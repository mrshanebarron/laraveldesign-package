<?php

namespace MrShaneBarron\LaravelDesign\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MenuItem extends Model
{
    protected $table = 'ld_menu_items';

    protected $fillable = [
        'menu_id',
        'parent_id',
        'label',
        'type',
        'url',
        'linkable_id',
        'linkable_type',
        'target',
        'css_class',
        'order',
    ];

    // Relationships
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')->orderBy('order');
    }

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }

    // Accessors
    public function getLinkAttribute(): string
    {
        if ($this->type === 'custom') {
            return $this->url ?? '#';
        }

        if ($this->linkable) {
            return $this->linkable->url ?? '#';
        }

        return '#';
    }

    public function getHasChildrenAttribute(): bool
    {
        return $this->children()->exists();
    }
}
