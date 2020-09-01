<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Mutation\Tag;

use App\Base\Logic\Generic\Tag\TagSave;
use App\Base\Logic\Lang\Translation\TranslationSave;
use App\Base\Model\Generic\Tag;
use App\Base\Model\Lang\Translation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TagUpdateTest extends TestCase
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

        $query = 'mutation tagUpdate($tagID: Int, $translationID:Int){
            tagUpdate(tagID: $tagID, translationID:$translationID) {
              data {
                text {
                  textID
                  text
                  langID
                }
              }
              messages {
                message
                type
              }
            }
        }';

        $expected = [
            'data' => [
                'tagUpdate' => [
                    'data' => [
                        'text' => [
                            'textID',
                            'text',
                            'langID',
                        ],
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
            'translationID' => $translation->id(),
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
