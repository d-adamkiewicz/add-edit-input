<?php
$config_filename = dirname(__FILE__) . '/config.inc';
if (!is_file("config.php")){
	chdir('../');
}
include_once("config.php");
include_once("helper.php");
$c = new Config($config_filename);
/*
$items = $c->items();
if ($_GET['all']){
	echo json_encode($items);
} else {
	$pg = array();
	foreach($items as $item){
		$pg[] = array('id'=>$item['pg']['name'], 'size'=>(string)($item['pg']['pdo_def'][1] ? $item['pg']['pdo_def'][1] : 1));
	}
	echo json_encode($pg);
}
*/
preprint(var_export($c, TRUE));
?>
