<?php

/**
 * Modify a hex color by the given number of steps (out of 255).
 *
 * Adapted from a solution by Torkil Johnsen.
 *
 * @param string $color
 * @param int $steps
 * @link http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function thanksroy_brighten($color, $steps) {
    $steps = max(-255, min(255, $steps));
    $hex = str_replace('#', '', $color);
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));
    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
     return '#'.$r_hex.$g_hex.$b_hex;
}

function drawSharedHeader() {
    return get_view()->partial('shared/header.php');
}

function drawSharedFooter() {
    return get_view()->partial('shared/footer.php');
}

function cutString($string, $length = 'medium') {

    switch ($length) {
        case 'short':
            $size = 90;
            break;
        
        case 'medium':
            $size = 180;
            break;

        case 'long':
            $size = 300;
            break;

        default:
            $size = is_integer($length) ? $length : 100;
            break;
    }

    $string = strip_tags($string); // Remove HTML tags

    if (strlen($string) <= $size) { // It's not necessary to cut the string
        return $string;
    }

    $string = substr($string, 0, $size); // Cut the string roughly

    $lastSpace = strrpos($string, ' '); // Find the position of the last space in the string

    $string = substr($string, 0, $lastSpace);

    return rtrim($string).'...';
}

