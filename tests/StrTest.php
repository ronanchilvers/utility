<?php

namespace Ronanchilvers\Utility\Test;

use PHPUnit\Framework\TestCase;
use Ronanchilvers\Utility\Str;

/**
 * Test case for Str string manipulations methods
 *
 * @author me
 */
class StrTest extends TestCase
{
    /**
     * Provider for singular / plural words
     *
     * @return array<array>
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function pluralsProvider()
    {
        return [
        //  singular    plural
            ['cat',     'cats'],
            ['boy',     'boys'],
            ['baby',    'babies'],
            ['lady',    'ladies'],
            ['leaf',    'leaves'],
            ['knife',   'knives'],
            ['match',   'matches'],
            ['dish',    'dishes'],
            ['bus',     'buses'],
            ['glass',   'glasses'],
            ['fox',     'foxes'],
            ['buzz',    'buzzes'],
            ['radio',   'radios'],
            ['ball',    'balls'],
            ['mango',   'mangoes'],
            ['sheep',   'sheep'],
            ['tooth',   'teeth'],
            ['mouse',   'mice'],
        ];
    }

    /**
     * Test that Str::plural() returns singular for count of 1
     *
     * @dataProvider pluralsProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testPluralReturnsSingularForCountOne($singular, $plural)
    {
        $this->assertEquals($singular, Str::plural($singular, 1));
    }

    /**
     * Test that Str::plural() converts known words correctly
     *
     * @dataProvider pluralsProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testPluralConvertsKnownWords($singular, $plural)
    {
        $this->assertEquals($plural, Str::plural($singular, 2));
    }

    /**
     * Test that explicit plurals are not returned for count == 1
     *
     * @dataProvider pluralsProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testExplicitPluralIsNotReturnedForCountOne($singular, $plural)
    {
        $this->assertEquals($singular, Str::plural($singular, 1, 'foobar'));
    }

    /**
     * Test that explicit plurals are returned for counts != 1
     *
     * @dataProvider pluralsProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testExplicitPluralIsReturned($singular, $plural)
    {
        $this->assertEquals('foobar', Str::plural($singular, 2, 'foobar'));
    }
}
