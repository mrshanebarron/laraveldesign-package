<?php

namespace MrShaneBarron\LaravelDesign\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'ld_menus';

    protected $fillable = [
        'name',
        'location',
    ];

    // Relationships
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('order');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }

    // Static methods
    public static function getByLocation(string $location): ?static
    {
        return static::where('location', $location)->first();
    }
}
