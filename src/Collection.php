<?php

namespace Ronanchilvers\Utility;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;

/**
 * Standard collection class providing useful methods for managing a collection of things
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Collection implements Countable, IteratorAggregate
{
    /**
     * @var array
     */
    protected $items;

    /**
     * Class constructor
     *
     * @param array $items
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Get the first item from the collection
     *
     * @return mixed
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * Get the last item from the collection
     *
     * @return mixed
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function last()
    {
        $value = end($this->items);
        reset($this->items);

        return $value;
    }

    /**
     * Get the item at a given array index
     *
     * @param mixed $index
     * @return mixed
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function at($index)
    {
        if (isset($this->items[$index])) {
            return $this->items[$index];
        }

        return null;
    }

    /**
     * Count this collection
     *
     * @return int
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Get an iterator instance
     *
     * @return Iterator
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}
