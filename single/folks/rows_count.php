<?php
$config_filename = dirname(__FILE__) . '/config.inc';
if (!is_file("select.inc")){
	chdir('../');
}
include_once('select.inc');
$c = new Config($config_filename);
$mydb = new MyPDO();
$rows_count = rows_count($c, $mydb);
echo "\$rows_count: " . $rows_count;
echo "<br>";
$map = index2id($c, $mydb);
echo "\$map: " . var_export($map, TRUE);
?>
