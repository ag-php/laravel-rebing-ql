<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Interfaces;

interface SearchByString
{
    public function __construct(string $string, string $column);

    public function query($query);
}
