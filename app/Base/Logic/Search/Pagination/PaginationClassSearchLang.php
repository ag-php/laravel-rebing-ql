<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination;

use App\Base\Logic\Search\Pagination\Items\PaginationLang;
use App\Base\Logic\Search\Pagination\Items\PaginationOrderBy;

class PaginationClassSearchLang extends PaginationClassSearch
{
    private PaginationLang $lang;

    public function __construct(PaginationOrderBy $orderBy, PaginationLang $lang)
    {
        parent::__construct($orderBy);
        $this->lang = $lang;
    }

    public function toArray(): array
    {
        $args = parent::toArray();
        $args['lang_id'] = $this->lang->toArray();

        return $args;
    }
}
