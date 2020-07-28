<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function getHistoryOrder($userId);
}
