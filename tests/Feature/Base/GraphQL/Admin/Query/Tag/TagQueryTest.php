<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Admin\Query\Tag;

use App\Base\Model\Generic\Tag;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TagQueryTest extends TestCase
{
    use WithoutMiddleware;

    public function test()
    {
        $tag = Tag::inRandomOrder()
            ->select('tag_id')
            ->first();

        $query = 'query tag($tagID: Int){
            tag(tagID: $tagID) {
              data {
                tagID
                text {
                  text
                }
              }
            }
        }';

        $expected = [
            'data' => [
                'tag' => [
                    'data' => [
                        'tagID',
                        'text' => [
                            'text',
                        ],
                    ],
                ],
            ],
        ];

        $variables = [
            'tagID' => $tag->tag_id,
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
