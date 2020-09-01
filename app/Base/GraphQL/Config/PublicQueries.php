<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Config;

class PublicQueries
{
    public static function queries(): array
    {
        return [
            \App\Base\GraphQL\Publics\Query\UserLoginQuery::class,
            \App\Base\GraphQL\Publics\Query\LangsQuery::class,
        ];
    }
}
