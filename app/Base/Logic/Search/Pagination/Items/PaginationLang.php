<?php

declare(strict_types=1);

namespace App\Base\Logic\Search\Pagination\Items;

use GraphQL\Type\Definition\Type;

class PaginationLang extends PaginationItem
{
    public function __construct($defaultValue = 'EN', $description = 'Lang for the title ID.')
    {
        parent::__construct(
            'lang_id',
            Type::string(),
            $description,
            $defaultValue,
            ['string']
        );
    }
}
