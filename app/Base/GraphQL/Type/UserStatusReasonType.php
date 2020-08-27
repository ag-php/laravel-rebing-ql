<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

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

    // phpcs:disable PEAR.Commenting.FunctionComment.Missing
    public function fields() : array
    {
        return [
            'user_status_reason_id' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'User Status Reason primary key',
            ],
            'user_id' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'User primary key',
            ],
            'user_status_id'       => [
                'type'        => Type::string(),
                'description' => 'User status',
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
            'created_at'          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Date to request the file',
                'resolve'     => function ($root) {
                    $dateFormat = new DateFormat($root->created_at);

                    return $dateFormat->getFullTime();
                },
            ],
        ];
    }

    //end fields()
}//end class
