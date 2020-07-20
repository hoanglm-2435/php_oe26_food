<?php

namespace Tests\Unit\Models;

use App\Models\Favourite;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Role;
use App\Models\Suggest;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->user);
    }

    public function test_table_name()
    {
        $this->assertEquals('users', $this->user->getTable());
    }

    public function test_fillable()
    {
        $this->assertEquals([
            'name',
            'email',
            'password',
            'address',
            'phone',
            'role_id',
        ], $this->user->getFillable());
    }

    public function test_hidden()
    {
        $this->assertEquals([
            'password',
            'remember_token',
        ], $this->user->getHidden());
    }

    public function test_casts()
    {
        $this->assertEquals([
            'email_verified_at' => 'datetime',
            'id' => 'int'
        ], $this->user->getCasts());
    }

    public function test_role_relation()
    {
        $this->test_belongsTo_relation(
            Role::class,
            'role_id',
            'id',
            $this->user->role()
        );
    }

    public function test_suggest_relation()
    {
        $this->test_hasMany_relation(
            Suggest::class,
            'user_id',
            $this->user->suggests()
        );
    }

    public function test_order_relation()
    {
        $this->test_hasMany_relation(
            Order::class,
            'user_id',
            $this->user->orders()
        );
    }

    public function test_favourite_relation()
    {
        $this->test_hasMany_relation(
            Favourite::class,
            'user_id',
            $this->user->favourites()
        );
    }

    public function test_rating_relation()
    {
        $this->test_hasMany_relation(
            Rating::class,
            'user_id',
            $this->user->ratings()
        );
    }
}
