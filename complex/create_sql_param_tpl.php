CREATE TABLE IF NOT EXISTS <?php echo $conf->table() . "_bind(\n" ?>
<?php echo $conf->prefix() . "_index SMALLINT\n" ?>
<?php echo "," .  $conf->prefix() . "_foreign_id SMALLINT\n" ?>
)CHARSET=UTF8
