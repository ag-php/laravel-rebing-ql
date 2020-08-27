<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

use GraphQL\Type\Definition\Type;

class PaginationLimit extends PaginationItem
{
    public function __construct($defaultValue = 24)
    {
        parent::__construct(
            'limit',
            Type::int(),
            'Limit result.',
            $defaultValue,
            [
                'integer',
                'min:1',
                'max:200',
            ]
        );
    }
}
