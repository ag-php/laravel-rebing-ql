<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Mutation\Tag;

use App\Base\Logic\Generic\Tag\TagSave;
use App\Base\Logic\Lang\Translation\TranslationSave;
use App\Base\Model\Generic\Tag;
use App\Base\Model\Lang\Translation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TagDeleteTest extends TestCase
{
    use WithoutMiddleware;

    public function test()
    {
        $translation = new TranslationSave(
            new Translation,
            [[
                'text' => 'Test to updated tag',
                'langID' => 'EN',
            ]],
            ['code' => uniqid()]
        );
        $translation->save();

        $tag = new TagSave(new Tag, $translation->id(), []);
        $tag->save();

        $query = 'mutation tagDelete($tagID: Int){
            tagDelete(tagID: $tagID) {
              data {
                tagID
              }
              messages {
                message
                type
              }
            }
        }';

        $expected = [
            'data' => [
                'tagDelete' => [
                    'data' => [
                        'tagID',
                    ],
                    'messages' => [
                        '*' => [
                            'message',
                            'type',
                        ],
                    ],
                ],
            ],
        ];

        $variables = [
            'tagID' => $tag->id(),
        ];

        $this->assertJsonStructureLogged(
            '/graphql/admin',
            [
                'query' => $query,
                'variables' => $variables,
            ],
            $expected
        );
    }
}
