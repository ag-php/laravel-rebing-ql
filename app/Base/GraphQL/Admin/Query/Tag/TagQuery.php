<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Query\Tag;

use App\Base\Exceptions\MessageError;
use App\Base\GraphQL\Classes\MessageWrapper;
use App\Base\Model\Generic\Tag;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class TagQuery extends Query
{
    protected $attributes = [
        'name'        => 'tag',
        'description' => 'A query to get the Tag Type',
    ];

    public function type(): Type
    {
        return MessageWrapper::type('TagType');
    }

    public function args(): array
    {
        return [
            'tagID' => [
                'type'  => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve(?Object $root, array $args): array
    {
        $tag = Tag::find($args['tagID']);
        if (! $tag) {
            throw new MessageError('Not found', 404);
        }
        $message = __(
            'graphql.created_success',
            ['item' => $args['tagID']]
        );

        return [
            'data' => $tag,
            'messages' => [],
        ];
    }
}
