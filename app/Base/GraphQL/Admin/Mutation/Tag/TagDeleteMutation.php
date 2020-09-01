<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Mutation\Tag;

use App\Base\Enums\SimpleMessage as SimpleMessageEnum;
use App\Base\GraphQL\Classes\MessageWrapper;
use App\Base\GraphQL\Classes\SimpleMessage;
use App\Base\Model\Generic\Tag;
use App\Base\Rules\Blocked;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Collection;
use Rebing\GraphQL\Support\Mutation;

class TagDeleteMutation extends Mutation
{
    protected $attributes = [
        'name' => 'tagDelete',
        'description' => 'Tag delete mutation',
    ];

    public function type(): Type
    {
        return MessageWrapper::type('TagType');
    }

    public function args(): array
    {
        return [
            'tagID' => [
                'type' => Type::int(),
                'rules' => [
                    'required',
                    'integer',
                    'exists:pgsql.generic.tag,tag_id',
                    new Blocked(
                        Tag::class,
                        'tag_id'
                    ),
                ],
            ],
        ];
    }

    public function resolve(?Object $root, array $args): array
    {
        $tag = Tag::find($args['tagID']);
        // phpstan think that $tag may be null
        // because it can see the validation in args
        // @phpstan-ignore-next-line
        $tag->delete();
        $msgTag = trans('graphql.deleted_success', ['item' => $args['tagID']]);

        return [
            'data' => $tag,
            'messages' => new Collection([new SimpleMessage($msgTag, SimpleMessageEnum::SUCCESS())]),
        ];
    }
}
