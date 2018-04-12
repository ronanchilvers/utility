<?php

namespace Ronanchilvers\Utility\Test;

use PHPUnit\Framework\TestCase;
use Ronanchilvers\Utility\Collection;

/**
 * Test suite for collection objects
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class CollectionTest extends TestCase
{
    /**
     * Get a new test instance
     *
     * @return \Ronanchilvers\Utility\Collection
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    protected function newInstance($array)
    {
        return new Collection($array);
    }

    /**
     * Array provider
     *
     * @return array
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function arrayProvider()
    {
        return [
            // Array                                         Count      First   Last        Value at Index      Index
            [  [],                                           0,         null,   null,       null,               1       ],
            [  ['one', 'two', 'three'],                      3,         'one',  'three',    'two',              1       ],
            [  ['a' => 'one', 'b' => 'two', 'c' => 'three'], 3,         'one',  'three',    'two',              'b'     ],
        ];
    }

    /**
     * Test that count works correctly with different arrays
     *
     * @dataProvider arrayProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testCountWorksForDifferentArrays($array, $count)
    {
        $instance = $this->newInstance($array);

        $this->assertEquals($count, $instance->count());
    }

    /**
     * Test that first() works with different arrays
     *
     * @dataProvider arrayProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testFirstWithDifferentArrays($array, $count, $first)
    {
        $instance = $this->newInstance($array);

        $this->assertEquals($first, $instance->first());
    }

    /**
     * Test that last() works with different arrays
     *
     * @dataProvider arrayProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testLastWithDifferentArrays($array, $count, $first, $last)
    {
        $instance = $this->newInstance($array);

        $this->assertEquals($last, $instance->last());
    }

    /**
     * Test that getting a key be index works
     *
     * @dataProvider arrayProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testAtWithDifferentArrays($array, $count, $first, $last, $indexValue, $index)
    {
        $instance = $this->newInstance($array);

        $this->assertEquals($indexValue, $instance->at($index));
    }

    /**
     * Test that we can get an array iterator for the correct array
     *
     * @dataProvider arrayProvider
     * @test
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function testGetIteratorWithDifferentArrays($array)
    {
        $instance = $this->newInstance($array);
        $iterator = $instance->getIterator();

        $this->assertEquals($array, $iterator->getArrayCopy());
    }
}
