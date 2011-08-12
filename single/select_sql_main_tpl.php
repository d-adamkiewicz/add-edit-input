SELECT
	@rownum:=@rownum+1 AS rownum
<?php echo "," . $conf->prefix() . "_id\n" ?>
<?php foreach($conf->items() as $val): ?>
<?php echo "," . $val['tb']['name'] . "\n" ?>
<?php endforeach;?>
<?php echo "," . $conf->prefix() . "_created\n" ?>
<?php echo "," . $conf->prefix() . "_updated\n" ?>
FROM (SELECT * FROM <?php echo $conf->table() ?> ORDER BY <?php echo $conf->prefix() . "_id" ?> ) v, (SELECT @rownum:=-1) r 
