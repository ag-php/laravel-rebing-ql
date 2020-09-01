<?php

declare(strict_types=1);

namespace App\Base\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoHTMLTags implements Rule
{
    public function passes($attribute, $value)
    {
        return ! preg_match('#<[^>]*>#', $value);
    }

    public function message()
    {
        return trans('validation.no_html_tags');
    }
}
