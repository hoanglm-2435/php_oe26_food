<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Tests\TestCase;

class OrderTest extends TestCase
{

    protected $order;

    protected function setUp(): void
    {
        parent::setUp();
        $this->order = new Order();
    }

    public function test_table_name()
    {
        $this->assertEquals('orders', $this->order->getTable());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->order);
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'user_id',
            'quantity',
            'total_price',
            'payment_type',
            'status',
            'note',
        ], $this->order->getFillable());
    }

    public function test_user_relation()
    {
        $this->test_belongsTo_relation(
            User::class,
            'user_id',
            'id',
            $this->order->user()
        );
    }

    public function test_orderItem_relation()
    {
        $this->test_hasMany_relation(
            OrderItem::class,
            'order_id',
            $this->order->orderItems()
        );
    }
}
