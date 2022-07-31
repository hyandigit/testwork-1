<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 *
 * @property integer $id
 * @property string $name
 * @property string $active
 */
class Location extends Model
{
    protected $table = 'locations';
    public static $tableName = 'locations';
    protected $fillable = ['name'];

    protected $appends = ['active'];
    const OPTION_ACTIVE = 0;

    public function blocks()
    {
        return $this->hasMany(Block::class,  'location_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->whereRaw('`options` & (1 << ' . static::OPTION_ACTIVE . ')');
    }


    /** MUTATION */
    public function getActiveAttribute()
    {
        $option = $this->attributes['option'] ?? 0;
        return ($option & (1 << static::OPTION_ACTIVE)) >> static::OPTION_ACTIVE;
    }
    /** END MUTATION */

    /**
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function get($id)
    {
        return static::query()->with('blocks')->where('id', '=', $id)->active()->first();
    }

}
