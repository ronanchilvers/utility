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
    static protected $irregulars = [
        'child'  => 'children',
        'foot'   => 'feet',
        'goose'  => 'geese',
        'man'    => 'men',
        'mouse'  => 'mice',
        'person' => 'people',
        'sheep'  => 'sheep',
        'tooth'  => 'teeth',
    ];

    /**
     * @var array
     */
    static protected $uncountable = [
        'sheep',
        'fish',
        'deer',
        'series',
        'species',
        'money',
        'rice',
        'information',
        'equipment'
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
    static public function plural($string, $count = 2, $plural = false)
    {
        $string = trim($string);
        if (in_array($string, static::$uncountable) && false === $plural) {
            return $string;
        }

        if (empty($string) || $count == 1) {
            return $string;
        }

        if (false !== $plural) {
            return $plural;
        }

        $string = mb_strtolower($string);
        if (isset(static::$irregulars[$string])) {
            return static::$irregulars[$string];
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
     * Singularise a string
     *
     * [1.0] 'ies' rule    (ends in a consonant + y : baby/lady)
     * [2.0] 'ves' rule    (ends in f or fe : leaf/knife) --- roof : rooves (correct but old english, roofs is ok).
     * [3.1] 'es' rule 1   (ends in a consonant + o : volcano/mango)
     * [3.2] 'es' rule 2   (ends in ch, sh, s, ss, x, z : match/dish/bus/glass/fox/buzz)
     * [4.1] 's' rule 1    (ends in a vowel + y or o : boy/radio)
     * [4.2] 's' rule 2    (ends in other than above : cat/ball)
     *
     * @param string $string The singular noun to singularise
     * @param int $count
     * @param string $singular
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function singular($string, $count = 1, $singular = false)
    {
        $string = trim($string);
        if (in_array($string, static::$uncountable) && false === $singular) {
            return $string;
        }

        if (empty($string) || $count !== 1) {
            return $string;
        }

        if (false !== $singular) {
            return $singular;
        }

        $singulars = array_flip(static::$irregulars);
        $string = mb_strtolower($string);
        if (isset($singulars[$string])) {
            return $singulars[$string];
        }

        // [1.0]
        if ('ies' == mb_substr($string, -3)) {
            return mb_substr($string, 0, -3) . 'y';
        }

        // [2.0]
        if ('ves' == mb_substr($string, -3)) {
            if (in_array(mb_substr($string, -4, 1), static::$vowels)) {
                return mb_substr($string, 0, -3) . 'f';
            }
        }

        // [3.1, 3.2]
        if ('ves' != mb_substr($string, -3) && 'es' == mb_substr($string, -2)) {
            return mb_substr($string, 0, -2);
        }

        return rtrim($string, 's');
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
     * @return string
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

    /**
     * Generate a long random string suitable for use as a token
     *
     * @param int $length
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function token($length = 64)
    {
        return substr(bin2hex(
            random_bytes($length)
        ), 0, $length);
    }

    /**
     * Create a string by joining an arbitrary number of other strings with a separator
     *
     * @param string $seperator
     * @param string $piece...
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function join($seperator, ...$pieces)
    {
        foreach ($pieces as &$piece) {
            $piece = trim($piece, $seperator);
        }

        return implode($seperator, $pieces);
    }

    /**
     * Convert a string to a boolean value
     *
     * @param string
     * @return boolean
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function bool($string)
    {
        if (true === $string) {
            return true;
        }
        switch ($string) {

            case '1':
            case 'yes':
            case 'true':
                return true;

            default:
                return false;

        }
    }

    /**
     * Simple moustaches templating
     *
     * @param string $template
     * @param array $params
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function moustaches(string $template, array $params)
    {
        $keys = array_map(function ($value) {
            return '{'.$value.'}';
        }, array_keys($params));
        $values = array_values($params);

        return str_replace($keys, $values, $template);
    }

    /**
     * Normalise a string into a key with only hyphens and lowercase alphanumeric characters
     *
     * @param string $string
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function normalise($string): string
    {
        $string = strtolower($string);
        $string = preg_replace('/[^A-z0-9\s-]+/', '', $string);
        $string = preg_replace('/[\s-]{1,}/', '-', $string);

        return $string;
    }
}
