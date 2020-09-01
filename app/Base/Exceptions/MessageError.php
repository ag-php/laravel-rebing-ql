<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting

namespace App\Base\Exceptions;

use GraphQL\Error\ClientAware;

class MessageError extends \Exception implements ClientAware
{

    public function __construct(string $message = null, int $code = 0)
    {
        if (! $message) {
            throw new $this('Unknown '.get_class($this));
        }

        parent::__construct($message, $code);
    }

    public function isClientSafe()
    {
        return true;
    }

    public function getCategory()
    {
        return 'message_error';
    }
}
