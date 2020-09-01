<?php

declare(strict_types=1);

namespace App\Base\Classes\Save;

use Illuminate\Database\Eloquent\Model;

interface IData
{
    /**
     * An SimpleMessage array to add to the messages response.
     *
     * @return array
     */
    public function messages(): array;

    public function data(): Model;

    public function save(): void;

    public function id(): int;
}
