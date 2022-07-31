<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\Store;
use App\Models\Location;
use App\Service\BlockService;
use App\Service\OrderService;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }
    public function store(Store $request, BlockService $blockService)
    {
        $data = $request->all();

        if ($this->service->store($data, $blockService)){
            return response([], 200);
        }
        return response([], 500);
    }
}
