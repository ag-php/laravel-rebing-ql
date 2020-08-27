<?php

declare(strict_types=1);

namespace App\Base\Logic\User;

use App\Base\Enums\UserStatus;
use App\Base\Exceptions\MessageError;
use App\Base\Model\Security\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginLogic
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function login()
    {
        if (Auth::check()) {
            throw new MessageError(__('user.logged_already'));
        }

        $user = User::where(['email' => $this->email])->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            throw new MessageError(__('user.login_wrong'));
        }

        if (! UserStatus::ACTIVE()->isEqual($user->user_status_id)) {
            throw new MessageError(__('user.no_active'));
        }

        $user['accessToken'] = $user->createToken('Albertcito.com')->accessToken;

        return $user;
    }
}
