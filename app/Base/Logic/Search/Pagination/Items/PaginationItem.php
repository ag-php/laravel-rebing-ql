<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

class PaginationItem
{
    public string $name;
    // @phpstan-ignore-next-line
    public $type;
    public string $description;
    // @phpstan-ignore-next-line
    public $defaultValue;
    public array $rules;

    // @phpstan-ignore-next-line
    public function __construct(
        string $name,
        $type,
        string $description,
        $defaultValue,
        array $rules
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->rules = $rules;
        $this->description = $description;
        $this->defaultValue = $defaultValue;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'rules' => $this->rules,
            'description' => $this->description,
            'defaultValue' => $this->defaultValue,
        ];
    }
}
