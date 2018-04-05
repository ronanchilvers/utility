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
    static protected $pluralExceptions = [
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
     * @param string
     * @return string
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function plural($string, $count = 1)
    {
        $string = trim($string);
        if (empty($string) || $count == 1) {
            return $string;
        }

        $string = strtolower($string);
        if (in_array($string, static::$pluralExceptions)) {
            return static::$pluralExceptions[$string];
        }

        // [1.0]
        if ('y' == substr($string, -1)) {
            return substr($string, 0, -1) . 'ies';
        }

        // [2.0]
        if ('f' == substr($string, -1) || 'fe' == substr($string, -2)) {
            $length = ('e' == substr($string, -1)) ? -2 : -1 ;
            return substr($string, $length) . 'ves';
        }

        // [3.1]
        if (!in_array(substr($string, -2, 1), static::$vowels) && 'o' == substr($string, -1)) {
            return $string . 'es';
        }

        // [3.2]
        if (in_array(substr($string, -2), ['ch', 'sh', 'ss']) || in_array(substr($string, -1), ['s', 'x', 'z'])) {
            return $string . 'es';
        }

        return $string . 's';
    }
}
