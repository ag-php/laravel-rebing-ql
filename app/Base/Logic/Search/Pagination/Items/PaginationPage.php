<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

use GraphQL\Type\Definition\Type;

class PaginationPage extends PaginationItem
{
    public function __construct($defaultValue = 1)
    {
        parent::__construct(
            'page',
            Type::int(),
            'Current page result.',
            $defaultValue,
            [
                'integer',
                'min:0',
            ]
        );
    }
}
