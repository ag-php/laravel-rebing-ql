<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;

class PaginationOrderBy extends PaginationItem
{
    public function __construct(string $defaultValue, array $columns)
    {
        $columnsList = implode(', ', $columns);
        parent::__construct(
            'orderBy',
            Type::string(),
            'Columns: '.$columnsList,
            $defaultValue,
            [Rule::in($columns)]
        );
    }
}
