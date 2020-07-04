<?php

namespace Tests;

use AppGati;
use Exception;
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

    public function testAddsStep()
    {
        $app = new AppGati;

        $app->step('test');
        $steps = $app->getSteps();

        $this->assertObjectHasAttribute('steps', $app);
        $this->assertArrayHasKey('test', $steps);
    }

    public function testAddStepException()
    {
        $app = new AppGati;

        $this->expectException(Exception::class);

        $app->step('test');
        $app->step('test');
    }

    public function testStep1And2AreDifferent()
    {
        $app = new AppGati;

        $test1 = $app->step('test1');

        \random_int(0, 100);

        $test2 = $app->step('test2');

        $this->assertIsArray($test1);
        $this->assertIsArray($test2);

        $this->assertArrayHasKey('time', $test1);
        $this->assertArrayHasKey('memory', $test1);
        $this->assertArrayHasKey('peak_memory', $test1);


        $this->assertArrayHasKey('time', $test2);
        $this->assertArrayHasKey('memory', $test2);
        $this->assertArrayHasKey('peak_memory', $test2);
    }

    public function testGetsTimeDifference()
    {
        $app = new AppGati;

        $app->step('test1');

        \usleep(100);

        $app->step('test2');

        $time = $app->getTimeDifference('test1', 'test2');

        $this->assertIsNumeric($time);
        $this->assertLessThanOrEqual(0.1, $time);
    }

    public function testGetsMemoryDifference()
    {
        $app = new AppGati;

        $app->step('test1');

        $i = 0;
        while ($i <= 1000) {
            \random_int(0, 1000);
            $i++;
        }

        $app->step('test2');

        $memory = $app->getMemoryDifference('test1', 'test2');

        $this->assertIsNumeric($memory);
        $this->assertGreaterThanOrEqual(1, $memory);
    }
}
