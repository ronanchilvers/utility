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

    /**
     * Copy files or folders from one location to another
     *
     * @param string $source
     * @param string $dest
     * @param int $mode The permissions mode for new folders
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function cp($source, $dest, $mode = 0750)
    {
        if (!is_readable($source) || (file_exists($dest) && !is_writable($dest))) {
            return false;
        }
        if (!is_dir($source) && !is_file($source)) {
            return false;
        }
        if (is_file($source)) {
            return copy($source, $dest);
        }
        if (!$dir = opendir($source)) {
            return false;
        }
        if (!mkdir($dest, $mode, true)) {
            return false;
        }
        while(false !== ( $file = readdir($dir)) ) {
            if (($file == '.') || ($file == '..')) {
                continue;
            }
            if (is_dir($source . '/' . $file) ) {
                if (!static::cp($source . '/' . $file, $dest . '/' . $file)) {
                    return false;
                }
            }
            else {
                if (!copy($source . '/' . $file, $dest . '/' . $file)) {
                    return false;
                }
            }
        }
        closedir($dir);

        return true;
    }

    /**
     * Remove a file or folder
     *
     * In the case of folders, the removal is recursive
     *
     * @param string $path
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function rm($path)
    {
        if (!is_writable($path)) {
            return false;
        }
        if (!is_dir($path) && !is_file($path)) {
            return false;
        }
        if (is_file($path)) {
            return unlink($path);
        }
        if (!$dir = opendir($path)) {
            return false;
        }
        while(false !== ( $file = readdir($dir)) ) {
            if (($file == '.') || ($file == '..')) {
                continue;
            }
            $thisPath = static::join($path, $file);
            if (is_link($thisPath)) {
                if (!unlink($thisPath)) {
                    return false;
                }
            } else if (is_dir($thisPath) ) {
                if (!static::rm($thisPath)) {
                    return false;
                }
            }
            else {
                if (!unlink($thisPath)) {
                    return false;
                }
            }
        }
        closedir($dir);

        return rmdir($path);
    }
}
