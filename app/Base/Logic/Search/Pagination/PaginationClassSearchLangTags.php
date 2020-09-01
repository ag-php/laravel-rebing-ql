<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination;

use App\Base\Logic\Search\Pagination\Items\PaginationLang;
use App\Base\Logic\Search\Pagination\Items\PaginationOrderBy;
use App\Base\Logic\Search\Pagination\Items\PaginationTags;

class PaginationClassSearchLangTags extends PaginationClassSearchLang
{
    private PaginationTags $tags;

    public function __construct(PaginationOrderBy $orderBy, PaginationLang $lang)
    {
        parent::__construct($orderBy, $lang);
        $this->tags = new PaginationTags();
    }

    public function toArray(): array
    {
        $args = parent::toArray();
        $args['tags'] = $this->tags->toArray();

        return $args;
    }
}
