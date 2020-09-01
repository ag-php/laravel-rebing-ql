<?php

declare(strict_types=1);

namespace Tests\Util;

use App\Base\Enums\UserStatus;
use App\Base\Model\Security\User;

class UserUtil
{
    public static function actingAs(array $columns = ['user.user_id', 'user.lang_id']): User
    {
        $where = [
            'user.user_status_id' => UserStatus::ACTIVE(),
            'user.email_verified' => true,
        ];

        return User::where($where)
            ->inRandomOrder()
            ->select($columns)
            ->first();
    }
}
