<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Config;

class Types
{
    public static function types(): array
    {
        return [
            \App\Base\GraphQL\Type\LangType::class,
            \App\Base\GraphQL\Type\PaginationType::class,
            \App\Base\GraphQL\Type\SimpleMessageType::class,
            \App\Base\GraphQL\Type\TextType::class,
            \App\Base\GraphQL\Type\TokenType::class,
            \App\Base\GraphQL\Type\TranslationType::class,
            \App\Base\GraphQL\Type\UserStatusType::class,
            \App\Base\GraphQL\Type\UserStatusReasonType::class,
            \App\Base\GraphQL\Type\UserType::class,
        ];
    }
}
