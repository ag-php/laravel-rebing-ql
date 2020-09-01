<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Config;

class AdminMutations
{
    public static function mutations(): array
    {
        return [
            \App\Base\GraphQL\Admin\Mutation\Translation\TranslationCreateMutation::class,
            \App\Base\GraphQL\Admin\Mutation\Translation\TranslationUpdateMutation::class,
            \App\Base\GraphQL\Admin\Mutation\Translation\TranslationDeleteMutation::class,
        ];
    }
}
