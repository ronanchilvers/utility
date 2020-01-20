<?php

namespace Ronanchilvers\Utility\Number;

/**
 * Methods to calculate the volume of various different shapes
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Volume
{
    /**
     * Calculate the volume of a cuboid
     *
     * Formula:
     * ```
     *  V = w * h * l
     * ```
     *
     * @param float $height
     * @param float $width
     * @param float $depth
     * @return float
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function cuboid($height, $width, $depth): ?float
    {
        if (0 == (float) $height || 0 == (float) $width || 0 == (float) $depth)
        {
            return null;
        }

        return $height * $width * $depth;
    }

    /**
     * Calculate the volume of a cylinder
     *
     * Formula:
     * ```
     *  V = π * r2 * h
     * ```
     *
     * @param float $height
     * @param float $radius
     * @return float
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function cylinder($height, $radius): ?float
    {
        if (0 == (float) $height || 0 == (float) $radius) {
            return null;
        }

        return pi() * pow((float) $radius, 2) * $height;
    }

    /**
     * Calculate the volume of a sphere
     *
     * Formula:
     * ```
     *  V = 4/3 * π * r3
     * ```
     * @param float $radius
     * @param float
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    static public function sphere($radius): ?float
    {
        if (0 == (float) $radius) {
            return null;
        }

        return (4/3) * pi() * pow($radius, 3);
    }

    /**
     * Calculate the volume of a hexagonal prism
     *
     * Formula:
     * ```
     * V = 3/2 * √3 * a2 *h
     * ```
     * @param float $height
     * @param float $edgeLength
     * @return float
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function hexagonalPrism($height, $edgeLength): ?float
    {
        return (3/2) * sqrt(3) * pow($edgeLength, 2) * $height;
    }
}
