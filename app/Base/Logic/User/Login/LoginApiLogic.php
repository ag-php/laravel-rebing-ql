<?php

declare(strict_types=1);

namespace App\Base\Logic\User\Login;

use App\Base\Model\Security\User;
use App\Base\Logic\User\Login\{
    LoginUserLogic,
    LoginTokenLogic
};

class LoginApiLogic
{
    private LoginUserLogic $loginUserLogic;

    public function __construct(LoginUserLogic $loginUserLogic)
    {
        $this->loginUserLogic = $loginUserLogic;
    }

    public function getUserWithToken(): User
    {
        $user = $this->loginUserLogic->getUser();
        $loginTokenLogic = new LoginTokenLogic($user);
        $user['accessToken'] = $loginTokenLogic->getToken();
        return $user;
    }
}
