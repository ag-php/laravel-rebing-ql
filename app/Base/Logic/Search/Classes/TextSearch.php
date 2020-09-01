<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Classes;

use App\Base\Logic\Search\Interfaces\SearchByString;
use Illuminate\Database\Eloquent\Builder;

class TextSearch implements SearchByString
{
    private string $text;
    private string $column;

    public function __construct(string $text, string $column)
    {
        $this->text = $text;
        $this->column = $column;
    }

    public function query(Builder $query): void
    {
        // Possible security issue with column variable
        $query->whereRaw(
            'lang.unaccent('.$this->column.') ilike lang.unaccent(?)',
            [
                '%'.$this->text.'%',
            ]
        );
    }
}
