<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Interfaces;

interface SearchByTranslation
{
    public function __construct(string $column, string $lang_id);

    public function query($query);
}
