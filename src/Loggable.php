<?php namespace Bmartel\Logbook;

/**
 * Trait Loggable
 *
 * @package Bmartel\Logbook
 */
trait Loggable
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function logEntries()
    {
        return $this->morphMany('Bmartel\Logbook\LogEntry', 'model');
    }

    /**
     * @return array
     */
    public function propertiesToLog()
    {
        $eligibleProperties = $this->getEligibleProperties();

        return array_only($this->getDirty(), $eligibleProperties);
    }

    protected function getEligibleProperties()
    {
        if (property_exists($this, 'loggable') && !empty($this->loggable)) {
            return $this->loggable;
        }

        return $this->fillable;
    }

    /**
     * Register the changelog observer
     */
    public static function bootLoggable()
    {
        static::observe(app('Bmartel\Logbook\ChangeLogObserver'));
    }
}
