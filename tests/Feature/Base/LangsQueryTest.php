<?php

declare(strict_types=1);

namespace Tests\Feature\Base;

use Tests\TestCase;

class LangsQueryTest extends TestCase
{
    public function test()
    {
        $query = '{
            langs {
              data {
                langID
                name
                localName
                active
              }
            }
        }';

        $expected = [
            'data' => [
                'langs' => [
                    'data' => [
                        '*' => [
                            'langID',
                            'name',
                            'localName',
                            'active',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertJsonStructure(
            '/graphql',
            [
                'query' => $query,
            ],
            $expected
        );
    }
}
