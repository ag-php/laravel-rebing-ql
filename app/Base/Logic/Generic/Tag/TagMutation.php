<?php

declare(strict_types=1);

namespace App\Base\Logic\Generic\Tag;

use App\Base\Classes\Save\TransactionSave;
use App\Base\GraphQL\Classes\MessageWrapper;
use App\Base\Model\Generic\Tag;
use App\Base\Rules\Blocked;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class TagMutation extends Mutation
{
    private string $event;

    public function __construct(string $event = 'create')
    {
        $this->event = $event;
    }

    public function type(): Type
    {
        return MessageWrapper::type('TagType');
    }

    public function args(): array
    {
        $args = [
            'translationID' => [
                'type'  => Type::int(),
                'rules' => [
                    'required',
                    'exists:pgsql.lang.translation,translation_id',
                ],
            ],
            'isBlocked' => [
                'type' => Type::boolean(),
            ],
        ];

        if ($this->event === 'update') {
            $args['tagID'] = [
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
            ];
        }

        return $args;
    }

    public function resolve(?Object $root, array $args): array
    {
        return (
            new TransactionSave(
                new TagSave(
                    isset($args['tagID']) ? Tag::find($args['tagID']) : new Tag(),
                    $args['translationID'],
                    $args
                )
            )
        )->saveMessage();
    }
}
