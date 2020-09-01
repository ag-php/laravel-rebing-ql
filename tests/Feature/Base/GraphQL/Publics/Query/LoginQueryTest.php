<?php

declare(strict_types=1);

namespace Tests\Feature\Base\GraphQL\Publics\Query;

use Tests\TestCase;

class LoginQueryTest extends TestCase
{
    public function test()
    {
        $variables = [
            'email' => 'me@albertcito.com',
            'password' => '123456',
        ];

        $query = 'query login($email: String, $password: String) {
            login(email:$email, password: $password) {
              userID
              name
              accessToken
            }
        }';

        $expected = [
            'data' => [
                'login' => [
                    'userID',
                    'name',
                    'accessToken',
                ],
            ],
        ];

        $this->assertJsonStructure(
            '/graphql',
            [
                'query' => $query,
                'variables' => $variables,
            ],
            $expected
        );
    }
}
