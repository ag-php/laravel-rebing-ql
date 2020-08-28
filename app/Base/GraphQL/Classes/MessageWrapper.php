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

use GraphQL;

/**
 * To find a string bettwen to strings
 * php version 7.2.10.
 *
 * @category GraphQL
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */
class MessageWrapper
{
    /**
     * Undocumented function.
     *
     * @param string $typeName type graphql
     *
     * @return void
     */
    public static function type(string $typeName, bool $list = false)
    {
        if ($list) {
            return GraphQL::wrapType(
                $typeName,
                $typeName.'Messages',
                WrapperListType::class
            );
        }

        return GraphQL::wrapType(
            $typeName,
            $typeName.'Messages',
            WrapperType::class
        );
    }

    //end type()
}//end class
