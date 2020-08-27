<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * To verify graphql endpoint with a user logged.
     *
     * @param string $url     The endpoint
     * @param array $params   [query, variables]
     * @param array $expected Expected JSON from the URL
     * @param User $user      User as logged
     * @return void
     */
    public function assertJsonStructureLogged(
        string $url,
        array $params,
        array $expected,
        $user = null
    ) {
        if (! $user) {
            $user = UserUtil::actingAs();
        }
        $response = $this->actingAs($user)
            ->json('post', $url, $params)
            ->assertStatus(200);
        try {
            $response->assertJsonStructure($expected);
        } catch (\Exception $ex) {
            $this->printDie($params, $expected, $ex, $response, $user->user_id);
        }
    }

    /**
     * To verify graphql endpoint.
     *
     * @param string $url     The endpoint
     * @param array $params   [query, variables]
     * @param array $expected Expected JSON from the URL
     * @return void
     */
    public function assertJsonStructure(
        string $url,
        array $params,
        array $expected
    ) {
        $response = $this->json('post', $url, $params);
        try {
            $response->assertStatus(200)->assertJsonStructure($expected);
        } catch (\Exception $ex) {
            $this->printDie($params, $expected, $ex, $response);
        }
    }

    private function printDie($params, $expected, \Exception $ex, $response, $user_id = null)
    {
        $content = substr($response->getContent(), 0, 1500);
        $trace = debug_backtrace();
        $error = [
            'class' => static::class.'::'.$trace[2]['function'],
            'params' => $params,
            'expected' => $expected,
            'user' => $user_id,
            'error' => $ex->toString(),
            'content' => $content,
        ];
        dd($error);
    }
}
