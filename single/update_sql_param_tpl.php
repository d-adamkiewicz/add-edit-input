UPDATE <?php echo $conf->table() . "_bind "; ?>
SET <?php echo $conf->prefix() . "_index=:" . $conf->prefix() . "_index, " . $conf->prefix() . "_foreign_id=:" . $conf->prefix() . "_foreign_id"; ?>
