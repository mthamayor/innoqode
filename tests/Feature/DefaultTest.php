<?php

namespace Tests\Feature;

use Tests\TestCase;

class DefaultTest extends TestCase
{
    /**
     * A basic not found test example.
     *
     * @return void
     */
    public function testRootApi()
    {
        $response = $this->get('api/');

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Welcome to innoqode assessment api.',
        ]);
    }

    /**
     * A basic not found test example.
     *
     * @return void
     */
    public function testEndpointNotFound()
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
