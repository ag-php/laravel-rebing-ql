<?php

declare(strict_types=1);

namespace App\Base\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self security()
 * @method static self lang()
 * @method static self generic()
 */
final class SchemaNames extends Enum
{
    const MAP_VALUE = [
        'security' => 'security',
        'lang' => 'lang',
        'generic' => 'generic',
    ];
}
