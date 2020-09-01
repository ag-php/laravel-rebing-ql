<?php

declare(strict_types=1);
namespace App\Base\Logic\Lang\Translation;

use App\Base\Globals\Langs;
use App\Base\Model\Lang\Lang;
use App\Base\Model\Lang\Translation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class TextField
{
    private string $type;

    public function __construct(string $type = 'TextType')
    {
        $this->type = $type;
    }

    public function text(string $id = 'translation_id', bool $optional = false): array
    {
        $defaultLang = Langs::getDefault();
        $type = GraphQL::type($this->type);

        return [
            'type' => $optional ? $type : Type::nonNull($type),
            'description' => 'Current text in the language selected.',
            'args' => [
                'lang_id' => [
                    'type' => Type::string(),
                    'defaultValue' => $defaultLang,
                ],
            ],
            'resolve' => function ($root, $args) use ($id, $optional) {
                if (! Lang::find($args['lang_id'])) {
                    $error = 'The Lang "'.$args['lang_id'].'" is not available.';
                    throw new \Exception($error);
                }
                if ($optional && $root[$id] === null) {
                    return;
                }
                $translation = Translation::find($root[$id]);

                return $translation->text($args['lang_id']);
            },
        ];
    }

    public function texts(string $id = 'translation_id', bool $optional = false): array
    {
        return [
            'type' => Type::listOf(GraphQL::type($this->type)),
            'description' => 'A list of text in the languages availables',
            'resolve' => function ($root, $args) use ($id, $optional) {
                if (! array_key_exists($id, $args) && $optional) {
                    return;
                }
                $translation = Translation::find($root[$id]);

                // @phpstan-ignore-next-line
                return $translation->texts()->get();
            },
        ];
    }
}
