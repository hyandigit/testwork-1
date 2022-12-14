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

    protected $appends = ['active'];
    const OPTION_ACTIVE = 0;
    public $volume = 2;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function scopeActive($query)
    {
        $query->whereRaw('`options` & (1 << ' . static::OPTION_ACTIVE . ')');
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
    public function getActiveAttribute()
    {
        $option = $this->attributes['option'] ?? 0;
        return ($option & (1 << static::OPTION_ACTIVE)) >> static::OPTION_ACTIVE;
    }
    /** END MUTATION */

}
