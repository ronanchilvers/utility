<?php

namespace Ronanchilvers\Utility;

/**
 * Useful operations for files
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class File
{
    /**
     * Join a set of paths together
     *
     * @param string $separator
     * @param string $piece...
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function join(...$pieces)
    {
        $separator = DIRECTORY_SEPARATOR;
        $prefix    = ($separator == substr($pieces[0],0,1)) ? $separator : '';
        foreach ($pieces as &$piece) {
            $piece = trim($piece, $separator);
        }

        return $prefix . implode($separator, $pieces);
    }
}
