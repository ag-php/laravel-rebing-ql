<?php

namespace App\Base\GraphQL\Admin\Query\User;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Facades\Auth;

class LogoutQuery extends Query
{

    protected $attributes = [
        'name'        => 'logout',
        'description' => 'A query to revoke token',
    ];

    public function type(): Type
    {
        return GraphQL::type('SimpleMessageType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve(?Object $root, array $args): array
    {
        $user = \Auth::User();
        if ($user) {
            $token = $user->token();
            if ($token) {
                $token->revoke();
            }
        }

        return  ['message' => __('user.logout')];
    }

}
