<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Mutation\Translation;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TranslationCreateTest extends TestCase
{
    use WithoutMiddleware;

    public function test()
    {
        $query = 'mutation translationCreate($code:String, $texts:[TextInput]){
            translationCreate(texts:$texts, code:$code) {
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

        $expected = [
            'data' => [
                'translationCreate' => [
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

        $variables = [
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
