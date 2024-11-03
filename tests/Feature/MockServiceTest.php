<?php

namespace Tests\Feature;

use Tests\TestCase;

class MockServiceTest extends TestCase
{
    /**
     * Mock Service Test
     */
    public function test_mock_service(): void
    {
        $response = $this->get('/data/task/1');
        $response->assertStatus(200);

        json_decode($response->getContent());
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->assertTrue(false, 'Mock Servis Dosyası Hatalı');
        }

        $response_fail = $this->get('/data/task/-1');
        $response_fail->assertStatus(404);
    }
}
