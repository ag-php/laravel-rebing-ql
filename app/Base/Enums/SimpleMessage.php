<?php

declare(strict_types=1);

namespace App\Base\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self SUCCESS()
 * @method static self INFO()
 * @method static self WARNING()
 * @method static self ERROR()
 */
final class SimpleMessage extends Enum
{
    const MAP_VALUE = [
        'SUCCESS' => 'success',
        'INFO'    => 'info',
        'WARNING' => 'warning',
        'ERROR'   => 'error',
    ];
}
