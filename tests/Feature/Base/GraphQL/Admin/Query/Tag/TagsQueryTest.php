<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Query\Tag;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TagsQueryTest extends TestCase
{
    use WithoutMiddleware;

    public function test()
    {
        $query = '{
            tags {
              data {
                tagID
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
                'tags' => [
                    'data' => [
                        '*' => [
                            'tagID',
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
