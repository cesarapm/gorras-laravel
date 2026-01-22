<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
protected static function boot()
{
    parent::boot();

    static::updated(function ($product) {
        if ($product->wasChanged('image')) {
            $oldImage = $product->getOriginal('image');

            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }
    });

    static::deleting(function ($product) {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
    });
}




    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
