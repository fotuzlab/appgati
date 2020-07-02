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
        $actual = $app->getTime();

        $this->assertIsNumeric($actual);
        $this->assertGreaterThanOrEqual($expected, $actual);
    }

    public function testGivesUsageByFormat()
    {
        $app = new AppGati;

        $array = $app->getUsage('array');
        $string = $app->getUsage('string');

        $this->assertIsArray($array);
        $this->assertIsString($string);
    }

    public function testAddsStep()
    {
        $app = new AppGati;

        $app->step('test');

        $this->assertObjectHasAttribute('test_time', $app);
        $this->assertObjectHasAttribute('test_usage', $app);
        $this->assertObjectHasAttribute('test_memory', $app);
        $this->assertObjectHasAttribute('test_peak_memory', $app);
    }
}
