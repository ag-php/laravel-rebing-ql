<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Classes;

class TagsSearch
{
    private $tags;

    public function __construct(array $tags)
    {
        $this->tags = $tags;
    }

    public function query($query, $activityTable, $columnName)
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
