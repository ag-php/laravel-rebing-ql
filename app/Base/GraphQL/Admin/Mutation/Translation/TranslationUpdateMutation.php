<?php

namespace App\Base\GraphQL\Admin\Mutation\Translation;

use App\Base\Logic\Lang\Translation\TranslationMutation;

class TranslationUpdateMutation extends TranslationMutation
{

    public function __construct()
    {
        parent::__construct("update");
        $this->attributes = [
            'name' => 'translationUpdate',
            'description' => 'A mutation to update a translation'
        ];
    }

}
