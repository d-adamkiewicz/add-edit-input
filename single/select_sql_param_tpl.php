SELECT 
<?php echo $conf->prefix() . "_index\n" ?>
<?php echo "," . $conf->prefix() . "_foreign_id\n" ?>
FROM <?php echo $conf->table() . "_bind"?>
