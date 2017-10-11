<?php namespace Bmartel\Logbook;

use Illuminate\Contracts\Auth\Guard;


/**
 * Class ChangeLogObserver
 *
 * @package Bmartel\Logbook
 */
class ChangeLogObserver
{

    /**
     * @var null|int
     */
    protected $userId;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->userId = $auth->user() ? $auth->user()->getKey() : null;
    }

    /**
     * @param $model
     */
    public function created($model)
    {
        LogEntry::create($this->changeSet('create', $model));
    }

    /**
     * @param $model
     */
    public function updated($model)
    {
        $changeSet = $this->changeSet('update', $model);

        $this->logUpdatesFor($changeSet, $model);
    }

    /**
     * @param $model
     */
    public function deleted($model)
    {
        LogEntry::create($this->changeSet('delete', $model));
    }

    /**
     * @param $model
     */
    public function restored($model)
    {
        LogEntry::create($this->changeSet('restore', $model));
    }

    /**
     * @param $type
     * @param $model
     *
     * @return array
     */
    protected function changeSet($type, $model)
    {
        $data = [
            'change_type' => $type,
            'user_id'     => $this->userId,
            'model_type'  => get_class($model),
            'model_id'    => $model->getKey(),
        ];

        $data['change_set'] = md5(serialize($data) . time());

        return $data;
    }

    /**
     * @param array $changeSet
     * @param LoggableContract $model
     */
    protected function logUpdatesFor($changeSet, $model)
    {
        foreach ($model->propertiesToLog() as $attribute => $value) {
            $currentChangeSet = $changeSet + ['new_value' => $value];
            LogEntry::create($this->getLogEntries($currentChangeSet, $model, $attribute));
        }
    }

    /**
     * @param $changeSet
     * @param $model
     * @param $attribute
     *
     * @return mixed
     */
    protected function getLogEntries($changeSet, $model, $attribute)
    {
        $changeSet['property'] = $attribute;

        if (in_array($attribute, $model->getHidden())) {
            $changeSet['old_value'] = '***';
            $changeSet['new_value'] = '***';
        } else {
            $changeSet['old_value'] = $model->getOriginal($attribute);
        }

        return $changeSet;
    }

}
