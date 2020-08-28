<?php

declare(strict_types=1);

/**
 * To find a string bettwen to strings
 * php version 7.2.10.
 *
 * @category GraphQL
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */

namespace App\Base\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * To find a string bettwen to strings
 * php version 7.2.10.
 *
 * @category GraphQL
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */
class PaginationType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'PaginationType',
        'description' => 'A Pagination Fields Type type',
    ];

    /**
     * Undocumented function.
     *
     * @return array
     */
    public function fields() : array
    {
        return [
            'per'     => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Number of items returned per page',
                'resolve'     => function ($data): int {
                    return $data->perPage();
                },
                'selectable'  => false,
            ],
            'current' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Current page of the cursor',
                'resolve'     => function ($data): int {
                    return $data->currentPage();
                },
                'selectable'  => false,
            ],
            'from'    => [
                'type'        => Type::int(),
                'description' => 'Number of the first item returned',
                'resolve'     => function ($data): ?int {
                    return $data->firstItem();
                },
                'selectable'  => false,
            ],
            'to'      => [
                'type'        => Type::int(),
                'description' => 'Number of the last item returned',
                'resolve'     => function ($data): ?int {
                    return $data->lastItem();
                },
                'selectable'  => false,
            ],
            'total'   => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Number of total items selected by the query',
                'resolve'     => function ($data): int {
                    return $data->total();
                },
                'selectable'  => false,
            ],
            'last'    => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The last page (number of pages)',
                'resolve'     => function ($data): int {
                    return $data->lastPage();
                },
                'selectable'  => false,
            ],
            'has_more' => [
                'type'        => Type::nonNull(Type::boolean()),
                'description' => 'Determines if cursor has more pages after the current page',
                'resolve'     => function ($data): bool {
                    return $data->hasMorePages();
                },
                'selectable'  => false,
            ],
        ];
    }

    //end fields()
}//end class
