<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;

class PaginationOrder extends PaginationItem
{
    public function __construct()
    {
        parent::__construct(
            'order',
            Type::string(),
            'Order by desc or asc',
            'desc',
            [Rule::in(['desc', 'asc'])]
        );
    }
}
