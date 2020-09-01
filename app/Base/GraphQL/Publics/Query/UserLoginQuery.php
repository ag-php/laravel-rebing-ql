<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Publics\Query;

use App\Base\Logic\User\Login\LoginApiLogic;
use App\Base\Logic\User\Login\LoginUserLogic;
use App\Base\Model\Security\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UserLoginQuery extends Query
{
    protected $attributes = [
        'name'        => 'login',
        'description' => 'A query to login a user, return a user + accessToken',
    ];

    public function type(): Type
    {
        return GraphQL::type('UserType');
    }

    public function args(): array
    {
        return [
            'email'    => [
                'name'  => 'email',
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'email',
                ],
            ],
            'password' => [
                'name'  => 'password',
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'string',
                ],
            ],
        ];
    }

    public function resolve(?Object $root, array $args): User
    {
        $loginApiLogic = new LoginApiLogic(
            new LoginUserLogic(
                $args['email'],
                $args['password']
            )
        );

        return $loginApiLogic->getUserWithToken();
    }
}
