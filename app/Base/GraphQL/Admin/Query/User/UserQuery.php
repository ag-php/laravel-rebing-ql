<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Query\User;

use App\Base\Exceptions\MessageError;
use App\Base\GraphQL\Classes\MessageWrapper;
use App\Base\Model\Security\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UserQuery extends Query
{
    protected $attributes = [
        'name'        => 'user',
        'description' => 'A query to return a user',
    ];

    public function type(): Type
    {
        return MessageWrapper::type('UserType');
    }

    public function args(): array
    {
        return [
            'userID' => [
                'type'  => Type::int(),
                'rules' => [
                    'required',
                    'integer',
                    'min:1',
                ],
            ],
        ];
    }

    public function resolve(?Object $root, array $args): array
    {
        $user = User::find($args['userID']);
        if (! $user) {
            throw new MessageError('Not found', 404);
        }

        return[
            'data' =>  $user,
            'messages' => [],
        ];
    }
}
