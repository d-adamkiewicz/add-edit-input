CREATE TABLE <?php echo $conf->table() . "s(\n" ?>
<?php echo $conf->table() . "_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY\n" ?>
<?php foreach ($conf->items() as $val): ?>
<?php echo "," . $val['tb']['name'] . " " . $val['tb']['col_def'] . "\n" ?>
<?php endforeach; ?>
<?php echo "," . $conf->table() . "_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n" ?>
<?php echo "," . $conf->table() . "_updated TIMESTAMP NULL\n)CHARSET=UTF8" ?>
