<?php

declare(strict_types=1);

/**
 * To encode data to send in the URL or JSON
 * php version 7.2.10.
 *
 * @category GraphQL
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */

namespace App\Base\GraphQL\Classes;

use App\Base\Enums\SimpleMessage as SimpleMessageEnum;

/**
 * To encode data to send in the URL or JSON
 * php version 7.2.10.
 *
 * @category GraphQL
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.albertcito.com
 */
class SimpleMessage
{
    public string $message;

    public SimpleMessageEnum $type;

    public int $code;

    /**
     * Create a message to return to the users in frontend.
     *
     * string $message message to show
     * SimpleMessageType $type messageType enum value
     * int $code used like http status code or similar
     */
    public function __construct(
        string $message,
        SimpleMessageEnum $type,
        int $code = 0
    ) {
        $this->message = $message;
        $this->type = $type;
        $this->code = $code;
    }

    //end __construct()
}//end class
