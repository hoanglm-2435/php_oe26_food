<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'size_id',
        'quantity',
        'category_id',
        'price',
        'price_sale',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
