<?php

declare(strict_types=1);

namespace App\Base\Classes\Save;

interface IData
{
    /**
     * An SimpleMessage array to add to the messages response.
     *
     * @return array
     */
    public function messages(): array;

    public function data();

    public function save();

    public function id(): int;
}
