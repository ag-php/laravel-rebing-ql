<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

use GraphQL\Type\Definition\Type;

class PaginationLang extends PaginationItem
{
    public function __construct(
        string $defaultValue = 'EN',
        string $description = 'Lang for the title ID.'
    ) {
        parent::__construct(
            'langID',
            Type::string(),
            $description,
            $defaultValue,
            ['string']
        );
    }
}
