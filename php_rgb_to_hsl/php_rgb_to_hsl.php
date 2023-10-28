<?php

function RGB2HSL(int $R = 0, int $G = 0, int $B = 0, int $a = 1, string $out = 'web'): array|null
{
// todo add multiplicator for web use
    // Convert the RGB byte-values to percentages
    $R = ($R / 255); //0.69411764705882352941176470588235
    $G = ($G / 255);
    $B = ($B / 255);


    // Calculate a few basic values, the maximum value of R,G,B,A, the
    //   minimum value, and the difference of the two (chroma).

    // V:= Xmax:= With maximum component
    $xMax = $V = max($R, $G, $B);


    // Xmin:= With minimum component
    $xMin = min($R, $G, $B);

    // C:= With range (i. e. chroma)
    $chroma = $xMax - $xMin;

    // L:= With mid-range (i. e. lightness)
    $lightness = ($xMax + $xMin) / 2;

    // RGBA alpha to HSLA alpha
    $alpha = $a;


    //https://en.wikipedia.org/wiki/HSL_and_HSV#External_links calculate by
    //https://gist.github.com/brandonheyer/5254516
    // value array


    // is it achromatic // selbst auslöschend? if C = 0
    if ($chroma == 0) {
        return [
            'h' => 0,
            's' => 0,
            'l' => round($lightness, 2),
            'a' => round($alpha, 2),
            'main_base_name' => 'gray',

        ];
    }

    ## SATURATION
    // calculate saturation's
    // Sv=
    if ($V == 0) {
        $saturation = 0;
    }
    if($V !== 0){
        $saturation = $chroma / $V;
    }

    // Sl:=
    if ($lightness == 0 or $lightness == 1) {
        $saturation = 0;
    }
    if ($lightness !== 0 and $lightness > 1){
        $saturation = $chroma / (1 - abs(2 * $lightness - 1));
    }
    ##

    ## HUE CALC
    // calculate hue by case witch if hue in most max range R or G or B
    // red is the max
    if ($V == $R) {
        $hue = 60 * fmod((($G - $B) / $chroma), 6);
        if ($B > $G) {
            $hue += 360;
        }
        return [
            'h' => round($hue, 3),
            's' => round($saturation, 3),
            'l' => round($lightness, 3),
            'a' => round($alpha, 3),
            'main_base_name' => 'red',

        ];
    }

    // green is the max
    if ($V == $G) {
        $hue = 60 * (($B - $R) / $chroma + 2);
        return [
            'h' => round($hue, 3),
            's' => round($saturation, 3),
            'l' => round($lightness, 3),
            'a' => round($alpha, 3),
            'main_base_name' => 'green',

        ];
    }

    // blue is the max
    if ($V == $B) {
        $hue = 60 * (($R - $G) / $chroma + 4);
        return [
            'h' => round($hue, 3),
            's' => round($saturation, 3),
            'l' => round($lightness, 3),
            'a' => round($alpha, 3),
            'main_base_name' => 'blue',

        ];
    }

    return null;
}
