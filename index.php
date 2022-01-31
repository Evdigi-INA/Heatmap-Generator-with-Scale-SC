<?php

function hue2rgb($p, $q, $t){
    if($t < 0) { $t++; }
    if($t > 1) { $t--; }
    if($t < 1/6) { return $p + ($q - $p) * 6 * $t; }
    if($t < 1/2) { return $q; }
    if($t < 2/3) { return $p + ($q - $p) * (2/3 - $t) * 6; }
    return $p;
}

function hslToRgb($h, $s, $l){
#    var r, g, b;
	if($s == 0){
		$r = $g = $b = $l; // achromatic
	}else{
		if($l < 0.5){
			$q =$l * (1 + $s);
		} else {
			$q =$l + $s - $l * $s;
		}
		$p = 2 * $l - $q;
		$r = hue2rgb($p, $q, $h + 1/3);
		$g = hue2rgb($p, $q, $h);
		$b = hue2rgb($p, $q, $h - 1/3);
	}
	$return=array(floor($r * 255), floor($g * 255), floor($b * 255));
	return $return;
}

/**
 * Convert a number to a color using hsl, with range definition.
 * Example: if min/max are 0/1, and i is 0.75, the color is closer to green.
 * Example: if min/max are 0.5/1, and i is 0.75, the color is in the middle between red and green.
 * @param i (floating point, range 0 to 1)
 * param min (floating point, range 0 to 1, all i at and below this is red)
 * param max (floating point, range 0 to 1, all i at and above this is green)
 */
function numberToColorHsl($i, $min, $max) {
    $ratio = $i;
    if ($min> 0 || $max < 1) {
        if ($i < $min) {
            $ratio = 0;
        } elseif ($i > $max) {
            $ratio = 1;
        } else {
            $range = $max - $min;
            $ratio = ($i-$min) / $range;
        }
    }
    // as the function expects a value between 0 and 1, and red = 0° and green = 120°
    // we convert the input to the appropriate hue value
    $hue = $ratio * 1.2 / 3.60;
    //if (minMaxFactor!=1) hue /= minMaxFactor;
    //console.log(hue);

    // we convert hsl to rgb (saturation 100%, lightness 50%)
    $rgb = hslToRgb($hue, 1, .5);
    // we format to css value and return
    return 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')'; 
}

//set scale by tuning below variable
$scale = 10;

$listcolor ='';

for ($i=0; $i<=$scale; $i++) {
    $listcolor.='<li style="background-color:'. numberToColorHsl($i/$scale, 0, 1) .'">'.$i."</li>\n";
}

echo $listcolor;

?>