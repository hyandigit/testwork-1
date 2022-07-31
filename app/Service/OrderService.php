<?php

namespace App\Service;

use App\Models\Location;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function store($data, BlockService $blockService)
    {
        $location = Location::get($data['location']);
        $blocks = $blockService->getFreeBlocks($location, $data['temperature']);
        if (empty($blocks)) {
            throw new \Exception('Location not have free blocks', 500);
        }
        $size = 0;
        $allVolume = $data['size'];
        $blocksId = [];
        foreach ($blocks as $block) {
            $volume = ($block->volume - $block->size);
            $size += $volume;
            if ($allVolume) {
                if ($allVolume > $volume) {
                    $allVolume -= $volume;
                    $blocksId[$block->id] = ['size' => $volume];
                } else {
                    $blocksId[$block->id] = ['size' => $allVolume];
                }
            }
        }
        if ($size < $data['size']) {
            throw new \Exception('All volume of blocks do not have need volume', 500);
        }
        try {
            DB::beginTransaction();
            $order = new Order($data);
            $ret = $order->save();
            $order->blocks()->attach($blocksId);
        } catch (\Exception $e) {
            $ret = false;
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $ret;
    }
}
