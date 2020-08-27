<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Interfaces;

interface SearchByTag
{
    public function __construct(array $tags);

    public function query($query);
}
