<?php include 'RGB2HSL.php'?>
<!-- Example -->
<style>
    div {
        width: 1rem;
        height: 1rem;
    }
</style>

<?php try {
    $test = new RGB2HSL([0, 255, 0, 1]);
} catch (Exception $e) {
} ?>

Input: rgba(<?php echo $test->getInput() ?>)
<div style="background-color: rgba(<?php echo $test->getInput() ?>)"></div>
<br>

Output: hsla(<?php echo $test->output['h']?>, <?php echo $test->output['s']?>%, <?php echo $test->output['l']?>%, <?php echo $test->output['a']?>)
<div style="background: hsla(<?php echo $test->output['h']?>, <?php echo $test->output['s']?>%, <?php echo $test->output['l']?>%, <?php echo $test->output['a']?>)"></div>

