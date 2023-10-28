<?php include 'php_rgb_to_hsl.php'?>
<!-- Example -->
<style>
    div {
        width: 1rem;
        height: 1rem;
    }
</style>

<?php $test = RGB2HSL(222,230,170)?>

Input: rgb(222,230,170)
<div style="background-color: rgb(222,230,170)"></div>
<br>

Output: hsla(<?php echo round($test['h'])?>, <?php echo round($test['s'])?>%, <?php echo round($test['l'])?>%, <?php echo round($test['a'])?>)
<div style="background: hsla(<?php echo round($test['h'])?>, <?php echo round($test['s'])?>%, <?php echo round($test['l'])?>%, <?php echo round($test['a'])?>)"></div>

