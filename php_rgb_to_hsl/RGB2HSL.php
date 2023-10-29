<?php

class RGB2HSL
{

    public string $output_type = 'css';
    public array $types = ['css', 'plain'];

    public array $input;
    public array $output;

    /**
     * @throws Exception
     */
    public function __construct(array $rgba, string $output_type = '')
    {
        if (!empty($output_type)) {
            $this->output_type = $output_type;
        }

        if (null != $rgba) {
            $this->input = $rgba;
            $this->convertRGBtoHSL($rgba);
        }
    }

    /**
     * @throws Exception
     */
    public function convertRGBtoHSL($rgba): bool
    {
// todo add multiplicator for web use

        if (is_array($rgba) === FALSE) {
            throw new Exception('Required array rgba(127,12,13,0.1)');
        }

        // Convert the RGB byte-values to percentages
        $R = ($rgba[0] / 255); //0.69411764705882352941176470588235
        $G = ($rgba[1] / 255);
        $B = ($rgba[2] / 255);

        // alpha?
        $A = 1;
        if(key_exists(3,$rgba)){
            $A = $rgba[3];
        }



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
        $alpha = $A;


        //https://en.wikipedia.org/wiki/HSL_and_HSV#External_links calculate by
        //https://gist.github.com/brandonheyer/5254516
        // value array


        // is it achromatic // selbst auslöschend? if C = 0
        if ($chroma == 0) {
            $this->parseOutput(0,0,$lightness,$alpha,'gray');
            return true;
        }

        ## SATURATION
        // calculate saturation's
        // Sv=
        if ($V == 0) {
            $saturation = 0;
        }else{
            $saturation = $chroma / $V;
        }

        // Sl:=
        if ($lightness == 0 or $lightness == 1) {
            $saturation = 0;
        }else{
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
            $this->parseOutput($hue,$saturation,$lightness,$alpha,'red');
            return true;
        }

        // green is the max
        if ($V == $G) {
            $hue = 60 * (($B - $R) / $chroma + 2);
            $this->parseOutput($hue,$saturation,$lightness,$alpha,'green');
            return true;
        }

        // blue is the max
        if ($V == $B) {
            $hue = 60 * (($R - $G) / $chroma + 4);
            $this->parseOutput($hue,$saturation,$lightness,$alpha,'blue');
            return true;
        }

        return false;
    }

    protected function parseOutput($h, $s, $l, $a,$name)
    {
        $precision = 3;
        $multi = 0;

        if($this->output_type == 'css'){
            $precision = 0;
            $multi = 100;
        }

        $this->output = [
            'h' => round(($h), $precision),
            's' => round(($s*$multi), $precision),
            'l' => round(($l*$multi), $precision),
            'a' => round($a, $precision),
            'main_base_name' => $name,
        ];

        return true;
    }

    public function getInput(): string
    {
        $str = '';
        foreach ($this->input as $item){
            $str .= $item.',';
        }

        return substr_replace($str ,"", -1);
    }
}
