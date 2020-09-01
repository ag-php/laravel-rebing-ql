<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Mutation\Tag;

use App\Base\Logic\Lang\Translation\TranslationSave;
use App\Base\Model\Lang\Translation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TagCreateTest extends TestCase
{
    use WithoutMiddleware;

    public function test()
    {
        $translationSave = new TranslationSave(
            new Translation,
            [[
                'text' => 'Test to updated',
                'langID' => 'EN',
            ]],
            ['code' => uniqid()]
        );
        $translationSave->save();

        $query = 'mutation tagCreate($translationID:Int){
            tagCreate(translationID:$translationID) {
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
                'tagCreate' => [
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

        $variables = ['translationID' => $translationSave->id()];

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
