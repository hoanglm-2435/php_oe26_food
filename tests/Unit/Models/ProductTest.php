<?php

namespace Tests\Unit\Models;


use App\Models\Category;
use App\Models\Favourite;
use App\Models\Image;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Size;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->product);
    }

    public function test_table_name()
    {
        $this->assertEquals('products', $this->product->getTable());
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'name',
            'description',
            'size_id',
            'quantity',
            'category_id',
            'price',
            'price_sale',
        ], $this->product->getFillable());
    }

    public function test_orderItem_relation()
    {
        $this->test_hasMany_relation(
            OrderItem::class,
            'product_id',
            $this->product->orderItems()
        );
    }

    public function test_size_relation()
    {
        $this->test_belongsToMany_relation(
            Size::class,
            'product_id',
            'size_id',
            $this->product->sizes()
        );
    }

    public function test_image_relation()
    {
        $this->test_hasMany_relation(
            Image::class,
            'product_id',
            $this->product->images()
        );
    }

    public function test_category_relation()
    {
        $this->test_belongsTo_relation(
            Category::class,
            'category_id',
            'id',
            $this->product->category()
        );
    }

    public function test_favourite_relation()
    {
        $this->test_hasMany_relation(
            Favourite::class,
            'product_id',
            $this->product->favourites()
        );
    }

    public function test_rating_relation()
    {
        $this->test_hasMany_relation(
            Rating::class,
            'product_id',
            $this->product->ratings()
        );
    }
}
