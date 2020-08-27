<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

namespace App\Base\Model\Security;

use App\Base\Model\BaseModel;

class UserStatus extends BaseModel
{
    public $incrementing = false;

    protected $table = 'security.user_status';

    protected $primaryKey = 'user_status_id';

    protected $fillable = [
        'status_id',
        'description_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}//end class
