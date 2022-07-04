<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AddCategory;
use App\Models\Category;
use App\Models\ProductToOrder;
use App\Models\RelatedProduct;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'additionally',
        'description',
        'short_description',
        'gastro_combination',
        'alcohol_combination',
        'rennet_type',
        'nutrients',
        'aging',
        'image',
        'big_image',
        'parts',
        'whole_price',
        'whole_weight',
        'part_price',
        'action_whole_price',
        'action_part_price',
        'new',
        'action',
        'active',
        'category_id',
        'add_category_id'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'active' => true,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'parts' => 'boolean',
        'active' => 'boolean',
        'new' => 'boolean',
        'action' => 'boolean',
    ];

    /**
     * Bootstrap model event.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            if (!$model->slug) {
                self::updateSlug($model);
            }
        });

        static::updating(function($model) {
            if (!$model->slug) {
                self::updateSlug($model);
            }
        });
    }

    /**
     * Изображение товара
     *
     * @return string
     */
    public function getImageAttribute($value) {
        if ($value) {
            return asset($value);
        }
        return '/images/default.jpg';
    }

    /**
     * Изображение товара
     *
     * @return string
     */
    public function getBigImageAttribute($value) {
        // if (!file_exists(public_path($value))) {
        //     return '/images/default.jpg';
        // }
        return $value;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function addCategory()
    {
        return $this->belongsTo(AddCategory::class);
    }

    public function productToOrders()
    {
        return $this->hasMany(ProductToOrder::class);
    }

    /**
     * Get the related products
     */
    public function related()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id');
    }

    public static function getActions()
    {
        return static::where(function($query) {
            $query->where('action', 1)->orWhere('new', 1);
        })->where('active', 1)->get();
    }

    /**
     * Scope a query to add filter suggest
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApplyFilter($query, Request $request)
    {
        // поисковая строка
        if ($request->get('q')) {
            $query->where('name', 'LIKE', '%'.$request->get('q').'%')
                ->orWhere('additionally', 'LIKE', '%'.$request->get('q').'%');
        }
        return $query;
    }

    private static function updateSlug($model)
    {
        // produce a slug based on the name
        $slug = Str::slug($model->name);
        // check to see if any other slugs exist that are the same & count them
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        // if other slugs exist that are the same, append the count to the slug
        $model->slug = $count ? "{$slug}-{$count}" : $slug;
    }
}
