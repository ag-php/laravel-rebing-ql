<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Config;

class AdminQueries
{
    public static function queries(): array
    {
        return [
            \App\Base\GraphQL\Admin\Query\Translation\TranslationsQuery::class,
            \App\Base\GraphQL\Admin\Query\Translation\TranslationQuery::class,

            \App\Base\GraphQL\Admin\Query\Tag\TagsQuery::class,
            \App\Base\GraphQL\Admin\Query\Tag\TagQuery::class,

            \App\Base\GraphQL\Admin\Query\User\UsersQuery::class,
            \App\Base\GraphQL\Admin\Query\User\UserQuery::class,
            \App\Base\GraphQL\Admin\Query\User\LogoutQuery::class,
        ];
    }
}
