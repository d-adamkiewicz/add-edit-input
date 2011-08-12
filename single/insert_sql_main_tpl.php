INSERT INTO <?php echo $conf->table() . " (";  ?>
<?php $items = $conf->items(); $end = end($items); ?>
<?php foreach($items as $val):  ?>
<?php echo ($end == $val) ? $val['tb']['name'] : $val['tb']['name'] . ","; ?>
<?php endforeach; ?>
<?php echo ") "; ?>
VALUES (<?php foreach($items as $val):  ?>
<?php echo ($end == $val) ? ":" . $val['tb']['name'] : ":" . $val['tb']['name'] . ","; ?>
<?php endforeach; ?>
)
