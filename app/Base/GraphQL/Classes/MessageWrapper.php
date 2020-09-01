<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Classes;

use GraphQL;
use GraphQL\Type\Definition\Type;

class MessageWrapper
{
    public static function type(string $typeName, bool $list = false): Type
    {
        if ($list) {
            return GraphQL::wrapType(
                $typeName,
                $typeName.'Messages',
                WrapperListType::class
            );
        }

        return GraphQL::wrapType(
            $typeName,
            $typeName.'Messages',
            WrapperType::class
        );
    }
}
