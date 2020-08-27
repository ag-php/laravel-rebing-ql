<?php

declare(strict_types=1);

namespace App\Base\Model\Security;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'security.user';

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lang_id',
        'user_status_id',
        'email_verified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Every time that the user is create or update, this function is executed.
     * - Update created by in the user table.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        if (\Auth::check()) {
            static::updating(
                function ($model) {
                    $user = \Auth::User();
                    $model->updated_by = $user->user_id;

                    // If user updated his language. I have to update the
                    // app language
                    if ($model->user_id === $user->user_id
                        && $model->lang_id !== $user->lang_id
                    ) {
                        \App::setLocale($model->lang_id);
                    }
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
