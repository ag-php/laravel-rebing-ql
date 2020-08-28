<?php

/**
 * To find a string bettwen to strings
 * php version 7.2.10.
 *
 * @category GraphQL
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
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
 * @link     https://albertcito.com
 */
class WrapperType extends ObjectType
{
    /**
     * Undocumented function.
     *
     * @param string $typeName       Undocumented
     * @param string $customTypeName Undocumented
     */
    public function __construct(string $typeName, string $customTypeName)
    {
        $config = [
            'name'   => $customTypeName,
            'fields' => $this->getMessagesFields($typeName),
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
    protected function getMessagesFields(string $typeName): array
    {
        return [
            'data'     => [
                'type'        => GraphQL::type($typeName),
                'description' => 'List of items on the current page',
                'resolve'     => function ($data) {
                    if (isset($data['data'])) {
                        return $data['data'];
                    }

                    return $data;
                },
            ],
            'messages' => [
                'type'        => GraphQLType::listOf(GraphQL::type('SimpleMessageType')),
                'description' => 'List of messages',
                'resolve'     => function ($data): Collection {
                    return $data['messages'];
                },
            ],
        ];
    }

    //end getMessagesFields()
}//end class
