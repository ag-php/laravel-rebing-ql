<?php

declare(strict_types=1);

namespace App\Base\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    /**
     * Save the user to created or update the row in the DB.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        if (\Auth::check()) {
            static::updating(
                function ($model) {
                    $model->updated_by = \Auth::User()->user_id;
                }
            );

            static::creating(
                function ($model) {
                    $model->created_by = \Auth::User()->user_id;
                }
            );
        }
    }
}
