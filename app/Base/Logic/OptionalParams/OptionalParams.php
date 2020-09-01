<?php

declare(strict_types=1);

namespace App\Base\Logic\OptionalParams;

class OptionalParams
{
    protected array $optionals;

    protected string $optionalKey;

    public function __construct(array $optionals, string $optionalKey)
    {
        $this->optionals = $optionals;
        $this->optionalKey = $optionalKey;
    }

    /**
     * Return value from the optionals array. It can be any type to return.
     *
     * @return object
     */
    public function getValue(): object
    {
        return $this->optionals[$this->optionalKey];
    }

    /**
     * Return if the param exist in the optionals array or not.
     *
     * @return bool
     */
    public function existParam() : bool
    {
        return array_key_exists(
            $this->optionalKey,
            $this->optionals
        );
    }
}
