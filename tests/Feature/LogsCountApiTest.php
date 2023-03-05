<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogsCountApiTest extends TestCase
{

    public function testLogsCountApiWithoutFilter(): void
    {
        $response = $this->get('/api/logs/count');

        $response->assertStatus(200);
    }


    public function testLogsCountApiWithFilter(): void
    {

        $query = http_build_query([
            'serviceNames' => 'order-service,invoice-service',
            'statusCode' => '201',
            'startDate' => '2022/09/17',
            'endDate' => '2022/09/17',
        ]);

        $response = $this->get("/api/logs/count?$query");

        $response->assertJsonStructure([
            'count'
        ]);
        
        $response->assertStatus(200);
    }

    public function testLogsCountApiWithInvalidFilter(): void
    {

        $query = http_build_query([
            'serviceName' => 'order-service,invoice-service',
            'statusCode' => '201',
            'startDatee' => '2022/09/17',
            'endDate' => '2022/09/17',
        ]);

        $response = $this->get("/api/logs/count?$query");

        $response->assertJsonStructure([
            'errorMessage',
            'validInputs'
        ]);

        $response->assertStatus(400);
    }
}
