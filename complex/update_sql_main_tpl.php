UPDATE <?php echo $conf->table(); ?> 
SET <?php foreach($conf->items() as $val):?>
<?php echo $val['tb']['name'] . "=:" . $val['tb']['name'] . ","; ?>
<?php endforeach; ?>
<?php foreach($conf->foreign() as $f):?>
<?php echo $f['tb']['name'] . "=:" . $f['tb']['name'] . ","; ?>
<?php endforeach; ?>
<?php echo $conf->prefix() . "_updated=NOW()\n"; ?>
WHERE <?php echo $conf->prefix() . "_id=:" . $conf->prefix() . "_id"; ?>
