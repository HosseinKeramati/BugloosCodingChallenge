<?php

namespace Tests\Unit;

use App\Models\MicroserviceLog;
use PHPUnit\Framework\TestCase;

class LogsCountFilterTest extends TestCase
{
    public function testCheckCorrectLogsCountFilterInput(): void
    {
        $this->assertFalse(MicroserviceLog::logsCountHasWrongFilterInput(['serviceNames' => 'order-service', 'statusCode' => '201', 'startDate' => '2022/09/17', 'endDate' => '2022/09/17']));
    }

    public function testCheckWrongLogsCountFilterInput(): void
    {
        $this->assertTrue(MicroserviceLog::logsCountHasWrongFilterInput(['serviceName' => 'order-service', 'statusCode' => '201', 'startDate' => '2022/09/17', 'endDate' => '2022/09/17']));
    }
}
