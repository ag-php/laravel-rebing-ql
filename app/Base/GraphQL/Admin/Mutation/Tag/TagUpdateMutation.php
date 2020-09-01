<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Mutation\Tag;

use App\Base\Logic\Generic\Tag\TagMutation;

class TagUpdateMutation extends TagMutation
{
    public function __construct()
    {
        parent::__construct('update');
        $this->attributes = [
            'name' => 'tagUpdate',
            'description' => 'A mutation to update a tag',
        ];
    }
}
