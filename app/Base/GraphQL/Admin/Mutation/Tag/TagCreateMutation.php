<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Mutation\Tag;

use App\Base\Logic\Generic\Tag\TagMutation;

class TagCreateMutation extends TagMutation
{
    protected $attributes = [
        'name' => 'tagCreate',
        'description' => 'A mutation to create a new tag',
    ];
}
