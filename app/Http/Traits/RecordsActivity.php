<?php

namespace App\Http\Traits;

use App\Models\Activity;
use ReflectionClass;
use ReflectionException;

trait RecordsActivity
{
    /**
     * Boot records activity
     *
     * @return void
     */
    protected static function bootRecordsActivity(): void
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    /**
     * Get events to record for the current model
     *
     * @return array
     */
    public static function getActivitiesToRecord(): array
    {
        return ['created'];
    }

    /**
     * Get the activities for the given model
     *
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * Record event data to db
     *
     * @param string $event
     *
     * @throws ReflectionException
     *
     * @return void
     */
    protected function recordActivity(string $event): void
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    /**
     * Get activity type dynamically
     *
     * @param string $event
     *
     * @throws ReflectionException
     *
     * @return string
     */
    protected function getActivityType(string $event): string
    {
        return $event . '_' . strtolower((new ReflectionClass($this))->getShortName());
    }
}