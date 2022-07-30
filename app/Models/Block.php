<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 *
 * @property integer $id
 * @property string $name
 * @property integer $temperature
 * @property integer location_id
 */
class Block extends Model
{
    protected $table = 'blocks';
    public static $tableName = 'blocks';
    protected $fillable = ['name', 'temperature', 'location'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    /** MUTATION */
    public function getLocationAttribute()
    {
        if (isset($this->relations['location'])) {
            return $this->relations['location'];
        }
        return NULL;
    }
    public function setLocationAttribute($value)
    {
        $this->attributes['location_id'] = $value;
    }
    /** END MUTATION */

}
