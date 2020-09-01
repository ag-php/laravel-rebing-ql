<?php

declare(strict_types=1);

namespace App\Base\Classes;

class ArrayIDs
{
    private array $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function ids(string $key): array
    {
        return array_filter(
            array_map(
                function ($option) use ($key) {
                    if (array_key_exists($key, $option)) {
                        return $option[$key];
                    }
                },
                $this->array
            )
        );
    }
}
