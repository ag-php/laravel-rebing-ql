<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Type;

use App\Base\Logic\DateFormat\DateFormat;
use App\Base\Model\Security\UserStatus;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserStatusReasonType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'UserStatusReasonType',
        'description' => 'A type for User Status Reason',
    ];

    public function fields() : array
    {
        return [
            'userStatusReasonID' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'User Status Reason primary key',
                'alias' => 'user_status_reason_id',
            ],
            'userID' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'User primary key',
                'alias' => 'user_id',
            ],
            'userStatusID'       => [
                'type'        => Type::string(),
                'description' => 'User status',
                'alias' => 'user_status_id',
            ],
            'reason' => [
                'type'        => Type::string(),
                'description' => 'Reason description',
            ],
            'status'             => [
                'type'        => GraphQL::type('UserStatusType'),
                'description' => 'User Status',
                'resolve'     => function ($root) {
                    return UserStatus::find($root->user_status_id);
                },
            ],
            'createdAt'          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Date to request the file',
                'alias' => 'created_at',
                'resolve'     => function ($root) {
                    $dateFormat = new DateFormat($root->created_at);

                    return $dateFormat->getFullTime();
                },
            ],
        ];
    }

    //end fields()
}//end class
