<?php

namespace App\Service;

use App\Models\Order;

class OrderService
{
    public function store($data)
    {
        $order = new Order($data);
        return $order->save();
    }
}
