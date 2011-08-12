CREATE TABLE IF NOT EXISTS <?php echo $conf->table() . "(\n" ?>
<?php echo $conf->prefix() . "_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY\n" ?>
<?php foreach ($conf->items() as $val): ?>
<?php echo "," . $val['tb']['name'] . " " . $val['tb']['col_def'] . "\n" ?>
<?php endforeach; ?>
<?php echo "," . $conf->prefix() . "_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n" ?>
<?php echo "," . $conf->prefix() . "_updated TIMESTAMP NULL\n)CHARSET=UTF8" ?>
