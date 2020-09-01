<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Classes;

use App\Base\Logic\Search\Interfaces\SearchByTranslation;
use Illuminate\Database\Eloquent\Builder;

class TranslationSearch implements SearchByTranslation
{
    private string $lang_id;
    private string $column;

    public function __construct(string $column, string $lang_id)
    {
        $this->column = $column;
        $this->lang_id = $lang_id;
    }

    public function query(Builder $query): void
    {
        $column = $this->column;
        $lang_id = $this->lang_id;
        $query->join(
            'lang.vtext',
            function ($join) use ($column, $lang_id) {
                $join->on('vtext.translation_id', '=', $column)
                    ->where('vtext.lang_id', $lang_id);
            }
        );
    }
}
