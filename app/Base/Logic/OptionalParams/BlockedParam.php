<?php

declare(strict_types=1);

namespace App\Base\Logic\OptionalParams;

use App\Base\Exceptions\MessageError;
use App\Base\Globals\Roles;

/**
 * The user can block the value, but I cannot modified it after blocked it.
 *
 * @author Albert Tjornehoj <me@albertcito.com>
 */
class BlockedParam
{
    private bool $currentValue;
    private bool $allowSuperUser;
    private OptionalParams $optionalParams;

    public function __construct(
        array $optionals,
        bool $currentValue = false,
        bool $allowSuperUser = true
    ) {
        $optionalParams = new OptionalParams($optionals, 'is_blocked');
        $this->currentValue = $currentValue;
        $this->allowSuperUser = $allowSuperUser;
    }

    /**
     * Only a superuser can set is_blocked from true to false.
     *
     * @return bool
     */
    public function hasRights() : bool
    {
        $value = false;
        if ($this->optionalParams->existParam()) {
            $value = $this->optionalParams->getValue();
        }

        return
            ($this->currentValue === false && $value === false)
            || ($this->allowSuperUser && Roles::isSuperUser());
    }

    /**
     * Return the default value.
     * If the user does not have rights, return MessageError Exception.
     *
     * @return bool
     */
    public function getValueOrFail() : bool
    {
        // If the form is blocked. Only a super admin can modify it.
        if ($this->currentValue && ! $this->hasRights()) {
            throw with(new MessageError(__('graphql.blocked_no_right')));
        }

        return $this->getValue();
    }

    /**
     * Return value from the optionals array.
     *
     * @return bool
     */
    public function getValue(): bool
    {
        // If is true and the user does not have the rights, return true.
        if ($this->currentValue && ! $this->hasRights()) {
            return $this->currentValue;
        }

        // If doesn't exist param. Return the current value.
        if (! $this->optionalParams->existParam()) {
            return $this->currentValue;
        }

        return (bool) $this->optionalParams->getValue();
    }
}
