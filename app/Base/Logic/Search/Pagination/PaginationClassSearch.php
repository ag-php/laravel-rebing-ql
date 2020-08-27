<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination;

use App\Base\Logic\Search\Pagination\Items\PaginationOrderBy;
use App\Base\Logic\Search\Pagination\Items\PaginationSearch;

class PaginationClassSearch extends PaginationClass
{
    private PaginationSearch $search;

    public function __construct(PaginationOrderBy $orderBy)
    {
        parent::__construct($orderBy);
        $this->search = new PaginationSearch();
    }

    public function toArray()
    {
        $args = parent::toArray();
        $args['search'] = $this->search->toArray();

        return $args;
    }
}
