<?php

function RGB2HSL(int $R = 0, int $G = 0, int $B = 0, int $a = 0): array|null
{

    // Convert the RGB byte-values to percentages
    $R = ($R / 255); //0.69411764705882352941176470588235
    $G = ($G / 255);
    $B = ($B / 255);


    // Calculate a few basic values, the maximum value of R,G,B,A, the
    //   minimum value, and the difference of the two (chroma).

    // V:= Xmax:= With maximum component
    $xMax = max($R, $G, $B);

    // Xmin:= With minimum component
    $xMin = min($R, $G, $B);

    // C:= With range (i. e. chroma)
    $chroma = $xMax - $xMin;

    // L:= With mid-range (i. e. lightness)
    $lightness = $xMax + $xMin / 2;

    // convert RGBA alpha to HSLA alpha percentage
    $alpha = $a;
    if (!empty($a)) {
        $alpha = $a * 100;
    }

    //https://en.wikipedia.org/wiki/HSL_and_HSV#External_links calculate by
    //https://gist.github.com/brandonheyer/5254516
    // value array
    $hue = null;
    $saturation = null;
    $lightness = null;

    // is it achromatic // selbst auslöschend? if C = 0
    if ($chroma == 0){
        return [
            'h' => 0,
            's' => 0,
            'l' => $lightness,
            'a' => $alpha

        ];
    }

    ## SATURATION
    // calculate saturation's
    // Sv=
    if($xMax == 0){
        $chroma = 0;
    }

    // Sl:=
    if($lightness == 0 or $lightness == 1){
        $saturation = $chroma / ( 1 - abs( 2 * $lightness - 1 ) );
    }
    ##

    ## HUE CALC
    // calculate hue by case witch if hue in most max range R or G or B
    // red is the max
    if ($xMax == $R){
        $hue = 60 * fmod( ( ( $G - $B ) / $chroma ), 6 );
        return [
            'h' => $hue,
            's' => $saturation,
            'l' => $lightness,
            'a' => $alpha

        ];
    }

    // green is the max
    if ($xMax == $G){
        $hue = 60 * ( ( $B - $R ) / $chroma + 2 );
        return [
            'h' => $hue,
            's' => $saturation,
            'l' => $lightness,
            'a' => $alpha

        ];
    }

    // blue is the max
    if ($xMax == $B){
        $hue = 60 * ( ( $R - $G ) / $chroma + 4 );
        return [
            'h' => $hue,
            's' => $saturation,
            'l' => $lightness,
            'a' => $alpha

        ];
    }

    return null;
}

?>

<!-- Example -->
<style>
    div {
        width: 1rem;
        height: 1rem;
    }
</style>

<?php $test = RGB2HSL(222,230,170)?>

Input:
<div style="background-color: rgb(222,230,170)"></div><br>
Output:
<div style="background-color: hsl(<?php echo $test['h']?>,<?php echo $test['s']?>,<?php echo $test['l']?>)"></div>

