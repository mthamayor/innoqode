<?php

namespace Tests\Feature;

use Tests\TestCase;

class DefaultTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('api/undefinedRoute');

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'Not Found.',
            'errors' => [
                'route' => 'Route not found.'
            ]
        ]);
    }
}
