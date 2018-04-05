<?php

namespace Ronanchilvers\Utility;

/**
 * Useful string manipulation methods
 *
 * NB: This class only handles english strings - it is not aware of other languages
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Str
{
    /**
     * @var array
     */
    static protected $plurals = [
        'mouse' => 'mice',
        'sheep' => 'sheep',
        'tooth' => 'teeth',
    ];

    /**
     * @var array
     */
    static protected $vowels = [
        'a',
        'e',
        'i',
        'o',
        'u'
    ];

    /**
     * Pluralise a string
     *
     * [1.0] 'ies' rule    (ends in a consonant + y : baby/lady)
     * [2.0] 'ves' rule    (ends in f or fe : leaf/knife) --- roof : rooves (correct but old english, roofs is ok).
     * [3.1] 'es' rule 1   (ends in a consonant + o : volcano/mango)
     * [3.2] 'es' rule 2   (ends in ch, sh, s, ss, x, z : match/dish/bus/glass/fox/buzz)
     * [4.1] 's' rule 1    (ends in a vowel + y or o : boy/radio)
     * [4.2] 's' rule 2    (ends in other than above : cat/ball)
     *
     * @param string $string The singular noun to pluralise
     * @param int $count
     * @param string $plural
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function plural($string, $count = 1, $plural = false)
    {
        $string = trim($string);
        if (empty($string) || $count == 1) {
            return $string;
        }

        if (false !== $plural) {
            return $plural;
        }

        $string = mb_strtolower($string);
        if (isset(static::$plurals[$string])) {
            return static::$plurals[$string];
        }

        // [1.0]
        if (!in_array(mb_substr($string, -2, 1), static::$vowels) && 'y' == mb_substr($string, -1)) {
            return mb_substr($string, 0, -1) . 'ies';
        }

        // [2.0]
        if ('f' == mb_substr($string, -1) || 'fe' == mb_substr($string, -2)) {
            $length = ('e' == mb_substr($string, -1)) ? -2 : -1 ;
            return mb_substr($string, 0, $length) . 'ves';
        }

        // [3.1]
        if (!in_array(mb_substr($string, -2, 1), static::$vowels) && 'o' == mb_substr($string, -1)) {
            return $string . 'es';
        }

        // [3.2]
        if (in_array(mb_substr($string, -2), ['ch', 'sh', 'ss']) || in_array(mb_substr($string, -1), ['s', 'x', 'z'])) {
            return $string . 'es';
        }

        return $string . 's';
    }

    /**
     * Convert a string to PascalCase
     *
     * Pascal case is upper camel case, or camel case with the first
     * letter uppercased.
     *
     * @param string $string
     * @param array $allowed Allowed characters that won't be compressed
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function pascal($string, $allowed = [])
    {
        $string = mb_strtolower($string);
        $string = preg_replace('#[^a-z0-9' . implode('', $allowed) . ']+#', ' ', $string);
        $string = str_replace(' ', '', ucwords($string));

        return $string;
    }

    /**
     * Convert a string to camelCase
     *
     * We're taking camel case here to mean lower camel case, ie: the first
     * letter is lower case.
     *
     * @param string $string
     * @param array $allowed Allowed characters that won't be compressed
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function camel($string, $allowed = [])
    {
        return lcfirst(
            static::pascal($string, $allowed)
        );
    }

    /**
     * Snake case a string
     *
     * This method snake cases phrases and can also convert camelCase
     * and PascalCase strings to snake case.
     *
     * @param string $string
     * @param array $allowed Allowed characters that won't be compressed
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function snake($string, $allowed = [])
    {
        // $string = mb_strtolower($string);
        $string = preg_replace('#([A-Z]{1})#', ' $1', $string);
        $string = mb_strtolower(trim($string));
        $string = preg_replace('#[^a-z0-9' . implode('', $allowed) . ']{1,}#', ' ', $string);
        $string = str_replace(' ', '_', $string);

        return $string;
    }

    /**
     * Truncate a string to a given length, optionally respecting word
     * boundaries
     *
     * @param string $string The string to truncate
     * @param int $length The length to truncate to
     * @param string $suffix Suffix to tag on the end of the string
     * @param boolean $words Respect word boundaries
     * @param
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function truncate($string, $length, $suffix = '...', $words = false)
    {
        if ($length > mb_strlen($string)) {
            return $string;
        }
        if (false === $words) {
            return mb_substr($string, 0, $length - mb_strlen($suffix)) . $suffix;
        }
        $matches = [];
        preg_match(
            "/(^.{1," . ($length - mb_strlen($suffix)) . "})(?=\s|$).*/u",
            $string,
            $matches
        );
        if (!isset($matches[1])) {
            return mb_substr($string, 0, $length - mb_strlen($suffix)) . $suffix;
        }

        return $matches[1] . $suffix;
    }
}
