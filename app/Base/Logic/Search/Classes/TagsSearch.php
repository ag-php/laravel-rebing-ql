<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Classes;

use Illuminate\Database\Eloquent\Builder;

class TagsSearch
{
    private array $tags;

    public function __construct(array $tags)
    {
        $this->tags = $tags;
    }

    public function query(Builder $query, string $activityTable, string $columnName): void
    {
        $tags = $this->tags;
        $query->whereIn(
            $activityTable.'.'.$columnName,
            function ($query) use ($tags, $activityTable , $columnName) {
                $tableTag = $activityTable.'_tag';
                $query->select($tableTag.'.'.$columnName)
                    ->from($tableTag)
                    ->whereIn($tableTag.'.tag_id', $tags);
            }
        );
    }
}
