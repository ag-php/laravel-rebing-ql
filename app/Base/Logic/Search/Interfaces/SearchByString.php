<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface SearchByString
{
    public function __construct(string $string, string $column);

    public function query(Builder $query): void;
}
