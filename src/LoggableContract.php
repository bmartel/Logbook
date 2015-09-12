<?php namespace Bmartel\Logbook;

/**
 * Interface LoggableContract
 *
 * @package Bmartel\Logbook\
 */
interface LoggableContract
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function logEntries();

    /**
     * @return array
     */
    public function propertiesToLog();
}