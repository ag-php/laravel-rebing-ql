<?php

declare(strict_types=1);

namespace App\Base\Logic\User\Login;

use App\Base\Model\Security\User;

class LoginTokenLogic
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getToken(): string
    {
        return $this->user->createToken('Albertcito.com')->accessToken;
    }
}
