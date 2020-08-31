<?php

declare(strict_types=1);

namespace App\Base\Logic\User\Login;

use App\Base\Enums\UserStatus;
use App\Base\Exceptions\MessageError;
use App\Base\Model\Security\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginUserLogic
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getUser(): User
    {
        if (Auth::check()) {
            throw new MessageError(trans('user.logged_already'));
        }

        $user = User::where(['email' => $this->email])->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            throw new MessageError(trans('user.login_wrong'));
        }

        if (! UserStatus::ACTIVE()->isEqual($user->user_status_id)) {
            throw new MessageError(trans('user.no_active'));
        }

        return $user;
    }
}
