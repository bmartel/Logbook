<?php namespace Bmartel\Logbook;

use Illuminate\Database\Eloquent\Model;


/**
 * Class LogEntry
 *
 * @package Bmartel\Logbook
 */
class LogEntry extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'property',
        'user_id',
        'old_value',
        'new_value',
        'model_id',
        'model_type',
        'change_type',
        'change_set',
    ];

    /**
     * @param $query
     * @param $type
     *
     * @return mixed
     */
    public function scopeByChangeType($query, $type)
    {
        return $query->where('change_type', $type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(app('config')->get('auth.model'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
}
