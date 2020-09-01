<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Mutation\Translation;

use App\Base\Logic\Lang\Translation\TranslationSave;
use App\Base\Model\Lang\Translation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TranslationDeleteTest extends TestCase
{
    use WithoutMiddleware;

    public function test()
    {
        $translationSave = new TranslationSave(
            new Translation,
            [[
                'text' => 'Test to delete',
                'langID' => 'EN',
            ]],
            ['code' => uniqid()]
        );
        $translationSave->save();

        $query = 'mutation translationDelete($translationID: Int){
            translationDelete(translationID: $translationID) {
              data {
                translationID
              }
              messages {
                message
                type
              }
            }
        }';

        $variables = [
            'translationID' => $translationSave->id(),
        ];

        $expected = [
            'data' => [
                'translationDelete' => [
                    'data' => [
                        'translationID',
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
