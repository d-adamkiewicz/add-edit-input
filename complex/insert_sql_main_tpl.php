INSERT INTO <?php echo $conf->table() . " (";  ?>
<?php $items = $conf->items(); ?>
<?php foreach($items as $val):  ?>
<?php echo $val['tb']['name'] . ","; ?>
<?php endforeach; ?>
<?php $foreign = $conf->foreign(); $end = end($foreign); ?>
<?php foreach($foreign as $f): ?>
<?php echo ($end == $f) ? $f['tb']['name'] : $f['tb']['name'] . ","; ?>
<?php endforeach; ?>
<?php echo ") "; ?>
VALUES (<?php foreach($items as $val):  ?>
<?php echo ":" . $val['tb']['name'] . ","; ?>
<?php endforeach; ?>
<?php foreach($foreign as $f): ?>
<?php echo ($end == $f) ? ":" . $f['tb']['name'] : ":" . $f['tb']['name'] . ","; ?>
<?php endforeach; ?>
)
