<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'double',
        'in_stock' => 'bool',
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    protected $appends = ['image_url', 'categories_ids'];

    /**
     * Get the product's image url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(get: fn() => filter_var($this->image, FILTER_VALIDATE_URL) ? $this->image : asset('storage/' . $this->image),);
    }

    /**
     * Get the categoriesIds's.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function categoriesIds(): Attribute
    {
        return Attribute::make(get: fn() => $this->categories->pluck('id'),);
    }
}
