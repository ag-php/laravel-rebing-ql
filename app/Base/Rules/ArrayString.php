<?php

declare(strict_types=1);

namespace App\Base\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayString implements Rule
{
    /**
     * Determine if the array has duplicates or empty values.
     *
     * @param string $attribute
     * @param mixed $value array to evaluate
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = array_map('trim', $value);
        $result = array_filter($result);
        $result = array_unique($result);

        return count($result) === count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.array_string');
    }
}
