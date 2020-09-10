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
class WrapperListType extends ObjectType
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
                'type'        => GraphQLType::listOf(GraphQL::type($typeName)),
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
                'resolve'     => function ($data): array {
                    return $data['messages'];
                },
            ],
        ];
    }

    //end getMessagesFields()
}//end class
