var opt = new Object();
<?php if(!empty($options)): ?>
    <?php foreach($options as $key=>$val): ?>
        opt["<?=$key?>"] = "<?=$val?>";
    <?php endforeach; ?>
<?php endif; ?>
        opt["sticky"] = false;
$.jGrowl("<?=$text?>",opt);