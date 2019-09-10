<?php

namespace Ronanchilvers\Utility\Test;

use PHPUnit\Framework\TestCase;
use Ronanchilvers\Utility\File;

/**
 * Test case for File methods
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class FileTest extends TestCase
{
    /**
     * Test that Str::join works with simple strings
     *
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testJoinWorksWithSimplePaths()
    {
        $separator = DIRECTORY_SEPARATOR;
        $result = File::join('one', "two{$separator}three", 'four');

        $this->assertEquals("one{$separator}two{$separator}three{$separator}four", $result);
    }

    /**
     * Test that join cleans up separators
     *
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testJoinCleansUpSeparators()
    {
        $separator = DIRECTORY_SEPARATOR;
        $result    = File::join("one{$separator}", "{$separator}two", "{$separator}three{$separator}");

        $this->assertEquals("one{$separator}two{$separator}three", $result);
    }

    /**
     * Test that prefixed path separators are preserved
     *
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testPrefixedPathSeparatorsArePreserved()
    {
        $separator = DIRECTORY_SEPARATOR;
        $result    = File::join("{$separator}one", "two", "three");

        $this->assertEquals("{$separator}one{$separator}two{$separator}three", $result);
    }
}
