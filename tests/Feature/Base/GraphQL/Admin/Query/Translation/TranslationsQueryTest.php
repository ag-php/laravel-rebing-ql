<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Query\Translation;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TranslationsQueryTest extends TestCase
{
    use WithoutMiddleware;

    public function test()
    {
        $query = '{
            translations {
              data {
                translationID
                code
                text {
                  text
                }
              }
              pagination {
                total
              }
            }
        }';

        $expected = [
            'data' => [
                'translations' => [
                    'data' => [
                        '*' => [
                            'translationID',
                            'code',
                            'text' => [
                                'text',
                            ],
                        ],
                    ],
                    'pagination' => [
                        'total',
                    ],
                ],
            ],
        ];

        $this->assertJsonStructureLogged(
            '/graphql/admin',
            ['query' => $query],
            $expected
        );
    }
}
