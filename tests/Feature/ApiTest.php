<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{


    /*
     public function test_the_validate_route_returns_ok()
    {
        $response = $this->get('login');
        $response->assertStatus(200);
    }
    */

    public function test_the_validate_data_returns_bad_request()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('http://127.0.0.1:8000/api/v1/service/iot', ['sensor' => 'S:SENSOR001;T:19;H:42']);
        $response->assertBadRequest();
    }
    /*
    public function test_the_save_data_returns_ok_response()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('http://127.0.0.1:8000/api/v1/service/iot', ['trama' => 'S:SENSOR001;T:19;H:42']);
        $response->assertOk();
    }
    
    public function test_get_token_returns_ok_response()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post(
            'http://127.0.0.1:8000/api/v1/login',
            [
                'username' => 'cuenta_usuario',
                'password' => 'Pass0wrD'
            ]
        );
        $response->assertOk();
    }
    */
}
