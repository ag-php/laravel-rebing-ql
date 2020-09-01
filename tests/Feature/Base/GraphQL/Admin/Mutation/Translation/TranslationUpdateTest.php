<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Mutation\Translation;

use App\Base\Logic\Lang\Translation\TranslationSave;
use App\Base\Model\Lang\Translation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TranslationUpdateTest extends TestCase
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

        $query = 'mutation translationUpdate($translationID: Int, $code:String, $texts:[TextInput]){
            translationUpdate(translationID: $translationID, texts:$texts, code:$code) {
              data {
                translationID
                code
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

        $variables = [
            'translationID' => $translationSave->id(),
            'code' => uniqid(),
            'texts' => [
                [
                    'text' => 'uno',
                    'langID' => 'ES',
                ],
                [
                    'text' => 'one',
                    'langID' => 'EN',
                ],
            ],
        ];

        $expected = [
            'data' => [
                'translationUpdate' => [
                    'data' => [
                        'translationID',
                        'code',
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
