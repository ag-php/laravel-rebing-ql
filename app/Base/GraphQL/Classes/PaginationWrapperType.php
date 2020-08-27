<?php

/**
 * To find a string bettwen to strings
 * php version 7.2.10.
 *
 * @category GraphQL
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
 */

declare(strict_types=1);

namespace App\Base\GraphQL\Classes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Collection;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * To find a string bettwen to strings
 * php version 7.2.10.
 *
 * @category GraphQL
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
 */
class PaginationWrapperType extends ObjectType
{
    /**
     * Undocumented function.
     *
     * @param string $typeName Undocumented
     */
    public function __construct(string $typeName)
    {
        $config = [
            'name'   => $typeName.'Pagination',
            'fields' => $this->getPaginationFields($typeName),
        ];

        $underlyingType = GraphQL::type($typeName);
        if (isset($underlyingType->config['model'])) {
            $config['model'] = $underlyingType->config['model'];
        }

        parent::__construct($config);
    }

    //end __construct()

    /**
     * Undocumented function.
     *
     * @param string $typeName Undocumented
     *
     * @return array
     */
    protected function getPaginationFields(string $typeName): array
    {
        return [
            'data'       => [
                'type'        => GraphQLType::listOf(GraphQL::type($typeName)),
                'description' => 'List of items on the current page',
                'resolve'     => function ($data): Collection {
                    return $data['data']->getCollection();
                },
            ],
            'pagination' => [
                'type'        => GraphQLType::nonNull(GraphQL::type('PaginationType')),
                'description' => 'Number of total items selected by the query',
                'resolve'     => function ($data) {
                    return $data;
                },
                'selectable'  => false,
            ],
            'messages'   => [
                'type'        => GraphQLType::listOf(GraphQL::type('SimpleMessageType')),
                'description' => 'List of messages',
                'resolve'     => function ($data): Collection {
                    return $data['messages'];
                },
            ],
        ];
    }
}
