<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Mutation\Translation;

use App\Base\Logic\Lang\Translation\TranslationMutation;

class TranslationCreateMutation extends TranslationMutation
{
    protected $attributes = [
        'name' => 'translationCreate',
        'description' => 'A mutation to create a new translation',
    ];
}
