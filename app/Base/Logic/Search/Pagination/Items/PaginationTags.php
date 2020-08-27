<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

use GraphQL\Type\Definition\Type;

class PaginationTags extends PaginationItem
{
    public function __construct()
    {
        parent::__construct(
            'lang_id',
            Type::listOf(Type::int()),
            'To filter by tags',
            [],
            []
        );
    }
}
