<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

use GraphQL\Type\Definition\Type;

class PaginationSearch extends PaginationItem
{
    public function __construct($defaultValue = '', $description = 'Search parameter')
    {
        parent::__construct(
            'search',
            Type::string(),
            $description,
            $defaultValue,
            []
        );
    }
}
