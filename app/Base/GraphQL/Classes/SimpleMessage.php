<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Classes;

use App\Base\Enums\SimpleMessage as SimpleMessageEnum;

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
