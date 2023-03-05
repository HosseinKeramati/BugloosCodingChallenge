<?php

namespace Tests\Unit;

use App\console\Commands\SeedDbFromLogFile;
use PHPUnit\Framework\TestCase;

class SeedDbFromLogFileTest extends TestCase
{
    public function testConvertMonthToNumeric(): void
    {
        $this->assertEquals(SeedDbFromLogFile::convertMonthToNumeric('Sep'), 9);
    }

    public function testConvertDate(): void
    {
        $this->assertEquals(SeedDbFromLogFile::convertDate('12/Sep/2022'), '2022-09-12');
    }

    public function testParseDateTime(): void
    {
        $this->assertEquals(SeedDbFromLogFile::parseDateTime('17/Sep/2022:10:23:54'), '2022-09-17 10:23:54');
    }
}
