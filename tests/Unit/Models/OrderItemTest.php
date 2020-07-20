<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    protected $orderItem;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderItem = new OrderItem();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->orderItem);
    }

    public function test_table_name()
    {
        $this->assertEquals('order_items', $this->orderItem->getTable());
    }

    public function test_order_relation()
    {
        $this->test_belongsTo_relation(
            Order::class,
            'order_id',
            'id',
            $this->orderItem->order()
        );
    }

    public function test_product_relation()
    {
        $this->test_belongsTo_relation(
            Product::class,
            'product_id',
            'id',
            $this->orderItem->product()
        );
    }
}
