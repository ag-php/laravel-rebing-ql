<?php

declare(strict_types=1);

namespace App\Base\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self emailVerified()
 * @method static self forgotPass()
 */
final class TokenType extends Enum
{
    const MAP_VALUE = [
        'emailVerified' => 'email_verified',
        'forgotPass' => 'forgot_pass',
    ];
}
