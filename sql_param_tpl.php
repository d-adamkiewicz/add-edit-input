CREATE TABLE IF NOT EXISTS <?php echo $conf->table() . "s(\n" ?>
<?php echo $conf->table() . "_index SMALLINT\n" ?>
<?php echo "," .  $conf->table() . "_foreign_id SMALLINT\n" ?>
)CHARSET=UTF8
