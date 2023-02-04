<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('login');
        $response->assertStatus(200);
    }

    public function test_the_validate_data_returns_a_bad_request()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('http://127.0.0.1:8000/api/v1/service/iot', ['sensor' => 'S:SENSOR001;T:19;H:42']);
        $response->assertBadRequest();
    }

    public function test_the_save_data_returns_ok_response()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('http://127.0.0.1:8000/api/v1/service/iot', ['trama' => 'S:SENSOR001;T:19;H:42']);
        $response->assertOk();
    }
}
