<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\Store;
use App\Service\OrderService;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }
    public function store(Store $request)
    {
        $data = $request->all();
        if ($this->service->store($data)){
            return response([], 200);
        }
        return response([], 500);
    }
}
