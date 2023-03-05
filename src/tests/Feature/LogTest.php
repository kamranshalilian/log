<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Log;
use Tests\TestCase;

class LogTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testCount(): void
    {
        $response = $this->get('/logs/count');
        $result = json_decode($response->content());
        $this->assertEquals($result->count,Log::count());
    }
}
