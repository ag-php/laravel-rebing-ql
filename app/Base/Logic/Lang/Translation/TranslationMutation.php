<?php

declare(strict_types=1);

namespace App\Base\Logic\Lang\Translation;

use App\Base\Classes\Save\TransactionSave;
use App\Base\GraphQL\Classes\MessageWrapper;
use App\Base\Model\Lang\Translation;
use App\Base\Rules\Blocked;
use App\Base\Rules\NoHTMLTags;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class TranslationMutation extends Mutation
{
    private string $event;

    public function __construct(string $event = 'create')
    {
        $this->event = $event;
    }

    public function type(): Type
    {
        return MessageWrapper::type('TranslationType');
    }

    public function args(): array
    {
        $args = [
            'texts' => [
                'name' => 'texts',
                'type' => Type::listOf(GraphQL::type('TextInput')),
                'rules' => ['required'],
            ],
            'code' => [
                'type' => Type::string(),
                'rules' => [
                    new NoHTMLTags,
                    ($this->event === 'create') ? 'required' : '',
                ],
            ],
            'isBlocked' => [
                'type' => Type::boolean(),
            ],
        ];

        if ($this->event === 'update') {
            $args['translationID'] = [
                'type' => Type::int(),
                'rules' => [
                    'required',
                    'integer',
                    'exists:pgsql.lang.translation,translation_id',
                    new Blocked(
                        Translation::class,
                        'translation_id'
                    ),
                ],
            ];
        }

        return $args;
    }

    public function resolve(?Object $root, array $args): array
    {
        $translation = isset($args['translationID'])
            ? (Translation::where('translationID', $args['translationID'])->first() ?? new Translation())
            : new Translation();

        $save = new TransactionSave(
            new TranslationSave(
                $translation,
                $args['texts'],
                $args
            )
        );

        return $save->saveMessage();
    }
}
