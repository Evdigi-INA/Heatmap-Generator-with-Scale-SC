<?php

/**
 * Convert hue to RGB.
 * 
 * @param float $p
 * @param float $q
 * @param float $t
 * @return float
 */
function hueToRgb(float $p, float $q, float $t): float
{
    if ($t < 0) {
        $t++;
    } elseif ($t > 1) {
        $t--;
    } elseif ($t < 1 / 6) {
        return $p + ($q - $p) * 6 * $t;
    } elseif ($t < 1 / 2) {
        return $q;
    } elseif ($t < 2 / 3) {
        return $p + ($q - $p) * (2 / 3 - $t) * 6;
    }

    return $p;
}

/**
 * Convert hsl to rgb (saturation 100%, lightness 50%).
 * 
 * @param float $hue
 * @param float $saturation
 * @param float $lightness
 * @return array
 */
function hslToRgb(float $hue, float $saturation, float $lightness): array
{
    if ($saturation == 0) {
        $r = $g = $b = $lightness; // achromatic
    } else {
        if ($lightness < 0.5) {
            $q = $lightness * (1 + $saturation);
        } else {
            $q = $lightness + $saturation - $lightness * $saturation;
        }

        $p = 2 * $lightness - $q;

        $r = hueToRgb($p, $q, $hue + 1 / 3);
        $g = hueToRgb($p, $q, $hue);
        $b = hueToRgb($p, $q, $hue - 1 / 3);
    }

    return array(floor($r * 255), floor($g * 255), floor($b * 255));
}

/**
 * Convert a number to a color using hsl, with range definition.
 * Example: if min/max are 0/1, and i is 0.75, the color is closer to green.
 * Example: if min/max are 0.5/1, and i is 0.75, the color is in the middle between red and green.
 * 
 * @param float scale (floating point, range 0 to 1)
 * @param float min (floating point, range 0 to 1, all i at and below this is red)
 * @param float max (floating point, range 0 to 1, all i at and above this is green)
 * @return string
 */
function numberToColorHsl(float $scale, float $min, float $max): string
{
    $ratio = $scale;

    if ($min > 0 || $max < 1) {
        if ($scale < $min) {
            $ratio = 0;
        } elseif ($scale > $max) {
            $ratio = 1;
        } else {
            $range = $max - $min;
            $ratio = ($scale - $min) / $range;
        }
    }

    // as the function expects a value between 0 and 1, and red = 0° and green = 120°
    // we convert the input to the appropriate hue value
    $hue = $ratio * 1.2 / 3.60;

    // we convert hsl to rgb (saturation 100%, lightness 50%)
    $rgb = hslToRgb($hue, 1, .5);

    // we format to css value and return
    return "rgb($rgb[0],$rgb[1],$rgb[2])";
}
