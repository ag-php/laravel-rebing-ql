<?php

declare(strict_types=1);

namespace App\Base\Rules;

use App\Base\Logic\OptionalParams\BlockedParam;
use Illuminate\Contracts\Validation\Rule;

class Blocked implements Rule
{
    private string $model;
    private string $id_key;

    public function __construct(string $model, string $id_key)
    {
        $this->model = $model;
        $this->id_key = $id_key;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  bool  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $variables = request()->get('variables');
        //If it a new element
        if (! isset($variables[$this->id_key])) {
            return true;
        }

        $id = $variables[$this->id_key];
        $model = $this->model::find($id);
        $blockedParam = new BlockedParam(
            request()->get('variables'),
            $model->is_blocked
        );

        return $blockedParam->hasRights();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('graphql.item_blocked');
    }
}
