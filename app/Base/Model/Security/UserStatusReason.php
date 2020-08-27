<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

namespace App\Base\Model\Security;

use App\Base\Model\BaseModel;

class UserStatusReason extends BaseModel
{
    protected $table = 'security.user_status_reason';

    protected $primaryKey = 'user_status_reason_id';

    protected $fillable = [
        'user_id',
        'user_status_id',
        'reason',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
