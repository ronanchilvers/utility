<?php

namespace Ronanchilvers\Utility;

/**
 * Useful filesystem methods
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class File
{
    /**
     * Get a filename/uri from a resource
     *
     * This method calls realpath to
     *
     * @param resource $resource
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function filenameFromResource(/*resource*/ $resource): string
    {
        $meta = stream_get_meta_data($resource);
        $filename = $meta["uri"];
        if (false !== realpath($filename)) {
            return $filename;
        }

        return $meta['uri'];
    }
}
