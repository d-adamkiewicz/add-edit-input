<?php
$config_filename = dirname(__FILE__) . '/config.inc';
if (!is_file("select.inc")){
	chdir('../');
}
include_once("select.inc");
$c = new Config($config_filename);
$mydb = new MyPDO();
list($response, $rows_count) = select($c, $mydb);
echo json_encode($response['Result']);
?>
