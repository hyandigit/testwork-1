<?php

namespace App\Service;

use App\Models\Location;

class BlockService
{
    protected $volume = 2;

    /***
     * @param Location $location
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFreeBlocks(Location $location, $temperature)
    {
        return $location->blocks()->where('size', '<', $this->volume)->whereBetween('temperature', [$temperature - 2, $temperature + 2])->get();
    }
}
