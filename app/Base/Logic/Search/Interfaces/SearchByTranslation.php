<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Interfaces;
use Illuminate\Database\Eloquent\Builder;

interface SearchByTranslation
{
    public function __construct(string $column, string $lang_id);

    public function query(Builder $query): void;
}
