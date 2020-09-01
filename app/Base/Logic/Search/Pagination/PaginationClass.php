<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination;

use App\Base\Logic\Search\Pagination\Items\PaginationLimit;
use App\Base\Logic\Search\Pagination\Items\PaginationOrder;
use App\Base\Logic\Search\Pagination\Items\PaginationOrderBy;
use App\Base\Logic\Search\Pagination\Items\PaginationPage;

class PaginationClass
{
    private PaginationOrderBy $orderBy;
    private PaginationPage $page;
    private PaginationLimit $limit;
    private PaginationOrder $order;

    public function __construct(PaginationOrderBy $orderBy)
    {
        $this->orderBy = $orderBy;
        $this->page = new PaginationPage();
        $this->limit = new PaginationLimit();
        $this->order = new PaginationOrder();
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page->toArray(),
            'limit' => $this->limit->toArray(),
            'orderBy' => $this->orderBy->toArray(),
            'order' => $this->order->toArray(),
        ];
    }
}
