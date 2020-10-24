<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    /**
     * Изображение категории
     *
     * @return string
     */
    public function getImageAttribute($value): string {
        if (!file_exists(public_path($value))) {
            return '/images/default.jpg';
        }
        return $value;
    }

    /**
     * Товары категории
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Список всех категорий
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getCategories()
    {
        return Cache::remember('categories', $seconds = 60 * 60, function () {
            return self::with(['products'])->get();
        });
    }
}
