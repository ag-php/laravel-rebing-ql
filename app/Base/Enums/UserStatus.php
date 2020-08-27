<?php

declare(strict_types=1);

namespace App\Base\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self ACTIVE()
 * @method static self INACTIVE()
 * @method static self BLOCKED()
 */
final class UserStatus extends Enum
{
    const MAP_VALUE = [
        'ACTIVE'   => 'active',
        'INACTIVE' => 'inactive',
        'BLOCKED'  => 'blocked',
    ];
}
