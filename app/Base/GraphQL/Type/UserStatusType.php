<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

namespace App\Base\GraphQL\Type;

use App\Base\Globals\Langs;
use App\Base\Logic\DateFormat\DateFormat;
use App\Base\Model\Lang\Translation;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserStatusType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'UserStatusType',
        'description' => 'A type for User Status',
    ];

    // phpcs:disable PEAR.Commenting.FunctionComment.Missing
    public function fields() : array
    {
        $defaultLang = Langs::getDefault();

        return [
            'userStatusID'  => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'User Status primary key',
                'alias' => 'user_status_id',
            ],
            'statusID'      => [
                'type'        => Type::int(),
                'description' => 'Status id: translation id',
                'alias' => 'status_id',
            ],
            'status'        => [
                'type'        => Type::nonNull(GraphQL::type('TextType')),
                'description' => 'Status translation',
                'args'        => [
                    'langID' => [
                        'type'         => Type::string(),
                        'description'  => 'Language',
                        'defaultValue' => $defaultLang,
                    ],
                ],
                'resolve'     => function ($root, $args) {
                    $translation = Translation::find($root->status_id);

                    return $translation->text($args['langID']);
                },
            ],
            'descriptionID' => [
                'type'        => Type::int(),
                'description' => 'Staus description ID: translation id',
                'alias' => 'description_id',
            ],
            'description'   => [
                'type'        => GraphQL::type('TextType'),
                'description' => 'Status translation',
                'args'        => [
                    'lang_id' => [
                        'type'         => Type::string(),
                        'description'  => 'Language',
                        'defaultValue' => $defaultLang,
                    ],
                ],
                'resolve'     => function ($root, $args) {
                    if (property_exists($root, 'description_id') === false) {
                        return;
                    }

                    $translation = Translation::find($root->description_id);

                    return $translation->text($args['lang_id']);
                },
            ],
            'createdAt' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Date to request the file',
                'alias'       => 'created_at',
                'resolve'     => function ($root) {
                    $dateFormat = new DateFormat($root->created_at);

                    return $dateFormat->getFullTime();
                },
            ],
            'available'     => [
                'type'        => Type::boolean(),
                'description' => 'If the current status is available to be used in new users',
                'alias'       => 'available',
            ],
        ];
    }
}
