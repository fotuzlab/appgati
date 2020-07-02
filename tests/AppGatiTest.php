<?php

namespace Tests;

use AppGati;
use PHPUnit\Framework\TestCase;

class AppGatiTest extends TestCase
{
    public function testTimeIsMicroTime()
    {
        $app = new AppGati;

        $expected = \microtime(true);
        $actual = $app->time();

        $this->assertIsNumeric($actual);
        $this->assertGreaterThanOrEqual($expected, $actual);
    }

    public function testGivesUsageByFormat()
    {
        $app = new AppGati;

        $array = $app->usage('array');
        $string = $app->usage('string');

        $this->assertIsArray($array);
        $this->assertIsString($string);
    }
}
