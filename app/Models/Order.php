<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @property integer $id
 * @property integer $size
 * @property integer $temperature
 * @property integer $date_start
 * @property integer $date_end
 * @property $block
 */
class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['size', 'temperature', 'date_start', 'date_end'];

    protected $primaryKey  = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function blocks()
    {
        return $this->belongsToMany(Block::class, 'order_blocks', 'order_id', 'block_id');
    }

    private function incId($oldId, $offset)
    {
        $id = substr($oldId, $offset);
        $length = strlen($oldId);
        if ($id != ''){
            $id = ord($id);
            if ((($id >= 48) && ($id < 57)) || (($id >= 65) && ($id < 90))) {
                $id++;
            } elseif($id == 90) {
                $oldId = $this->incId(substr($oldId, 0, ($length) + $offset), $offset);
                $id = 48;
            } else {
                $id = 65;
            }
            $newId = str_split($oldId);
            $newId[($length) + $offset] = chr($id);
        }
        return implode('', $newId);
    }

    private function generateID()
    {
        $lastId = static::query()->select('id')->orderBy('id', 'DESC')->value('id');
        if (empty($lastId)) {
            $lastId = '100000000000';
        }
        return $this->incId($lastId, -1);
    }

    public function save(array $options = [])
    {
        $this->setAttribute('id', $this->generateID());
        return parent::save($options);
    }

    /** MUTATION */
    /** END MUTATION */
}
