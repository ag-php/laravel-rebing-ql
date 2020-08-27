<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

class PaginationItem
{
    public $name;
    public $type;
    public $description;
    public $defaultValue;
    public $rules;

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
