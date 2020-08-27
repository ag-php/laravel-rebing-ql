<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Type;

use App\Base\Model\Security\UserStatus;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'UserType',
        'description' => 'A type of User',
    ];

    public function fields() : array
    {
        return [
            'userID'        => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'User identification, primary key',
                'alias' => 'user_id',
            ],
            'langID'        => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'User language',
                'alias' => 'lang_id',
            ],
            'name'          => [
                'type'        => Type::nonNull(Type::string()),
                'rules'       => ['min:3'],
                'description' => 'User name',
            ],
            'email'         => [
                'type'        => Type::nonNull(Type::string()),
                'rules'       => ['min:3'],
                'description' => 'User email',
            ],
            'userStatusID'  => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'User Status, values: Active, Inactive, Blocked',
                'alias' => 'user_status_id',
            ],
            'status'        => [
                'type'        => GraphQL::type('UserStatusType'),
                'description' => 'User Status',
                'resolve'     => function ($root) {
                    return UserStatus::find($root->user_status_id);
                },
            ],
            'statusReason'  => [
                'type'        => Type::listOf(GraphQL::type('UserStatusReasonType')),
                'description' => 'User Status Reason',
                'alias' => 'status_reason',
                'resolve'     => function ($root) {
                    return $root->statusReasons()->get();
                },
            ],
            'emailVerified' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Email Validation flag, values: True, False',
                'alias' => 'email_verified',
            ],
            'accessToken'   => [
                'type'        => Type::string(),
                'description' => 'Session api token passport',
            ],
        ];
    }
}
