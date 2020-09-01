<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface SearchByTag
{
    public function __construct(array $tags);

    public function query(Builder $query): void;
}
