<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 *
 * @property integer $id
 * @property string $name
 */
class Location extends Model
{
    protected $table = 'locations';
    public static $tableName = 'locations';
    protected $fillable = ['name'];

    public function blocks()
    {
        return $this->hasMany(Block::class, 'id', 'location_id');
    }

}
