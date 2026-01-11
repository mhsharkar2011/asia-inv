<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Log an activity
     */
    protected function logActivity($type, $description, Model $related = null)
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        $activityData = [
            'user_id' => $user->id,
            'type' => $type,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        if ($related) {
            $activityData['related_id'] = $related->id;
            $activityData['related_type'] = get_class($related);
        }

        return Activity::create($activityData);
    }

    /**
     * Boot the trait
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', ucfirst(class_basename($model)) . ' created', $model);
        });

        static::updated(function ($model) {
            $model->logActivity('updated', ucfirst(class_basename($model)) . ' updated', $model);
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', ucfirst(class_basename($model)) . ' deleted', $model);
        });
    }
}
