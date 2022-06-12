<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'double',
        'in_stock' => 'bool',
    ];

    protected $appends = ['image_url'];

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => filter_var($this->image, FILTER_VALIDATE_URL) ? $this->image : asset('storage/' . $this->image),
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
