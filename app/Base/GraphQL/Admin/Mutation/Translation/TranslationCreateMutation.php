<?php

namespace App\Base\GraphQL\Admin\Mutation\Translation;

use App\Base\Logic\Lang\Translation\TranslationMutation;

class TranslationCreateMutation extends TranslationMutation
{
    protected $attributes = [
        'name' => 'translationCreate',
        'description' => 'A mutation to create a new translation'
    ];

}
