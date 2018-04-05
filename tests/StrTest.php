<?php

namespace Ronanchilvers\Utility\Test;

use PHPUnit\Framework\TestCase;
use Ronanchilvers\Utility\Str;

/**
 * Test case for Str string manipulations methods
 *
 * @author Ronan Chilvers <ronan@d3r.com>
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

    /**
     * Data provider for camel cased phrases
     *
     * @return array<array>
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function camelCaseProvider()
    {
        return [
            ['my_phrase', 'myPhrase'],
            ['one two three', 'oneTwoThree'],
        ];
    }

    /**
     * Test that Str::pascal() processes given phrases correctly
     *
     * @dataProvider camelCaseProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testGivenPhrasesArePascalCasedCorrectly($phrase, $camelCase)
    {
        $pascal = ucfirst($camelCase);
        $this->assertEquals($pascal, Str::pascal($phrase));
    }

    /**
     * Test that Str::camel() processes given phrases correctly
     *
     * @dataProvider camelCaseProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testGivenPhrasesAreCamelCasedCorrectly($phrase, $camelCase)
    {
        $this->assertEquals($camelCase, Str::camel($phrase));
    }

    /**
     * Provider for snake cased phrases
     *
     * @return array<array>
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function snakeCaseProvider()
    {
        return [
            ['one two three', 'one_two_three'],
            ['one.two.three', 'one_two_three'],
            ['oneTwoThree', 'one_two_three'],
            ['OneTwoThree', 'one_two_three'],
        ];
    }

    /**
     * Test that Str::snake() can convert known phrases
     *
     * @dataProvider snakeCaseProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testGivenPhrasesAreSnakeCasedCorrectly($phrase, $snakeCase)
    {
        $this->assertEquals($snakeCase, Str::snake($phrase));
    }

    /**
     * Test that truncating a string less than a given length works
     *
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testTruncateToLessThanLengthDoesNothing()
    {
        $this->assertEquals('foobar is great', Str::truncate('foobar is great', 100));
    }

    /**
     * Test that truncate works for string adding the default suffix
     *
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testTruncateReturnsCorrectStringWithSuffix()
    {
        $result = Str::truncate('foobar is great', 10);
        $this->assertEquals('foobar ...', $result);
        $this->assertEquals(10, mb_strlen($result));
    }

    /**
     * Test that passing a custom suffix works correctly
     *
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testTruncateWithCustomSuffixReturnsStringWithSuffix()
    {
        $result = Str::truncate('foobar is great', 10, '---');
        $this->assertEquals('foobar ---', $result);
        $this->assertEquals(10, mb_strlen($result));
    }

    /**
     * Test that truncate breaks on words when asked to
     *
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testTruncateRespectsWordBoundaries()
    {
        $result = Str::truncate('foobar is great', 12, '...', true);
        $this->assertEquals('foobar is...', $result);
        $this->assertEquals(12, mb_strlen($result));
    }

    /**
     * Test that a string with no word boundaries effectively disables word boundary support
     *
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testTruncateStringWithNoWordBoundariesDisablesWordBoundaries()
    {
        $result = Str::truncate('foobar_is_great', 11, '...', true);
        $this->assertEquals('foobar_i...', $result);
        $this->assertEquals(11, mb_strlen($result));
    }
}
