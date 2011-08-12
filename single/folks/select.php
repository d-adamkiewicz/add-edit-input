<?php
$config_filename = dirname(__FILE__) . '/config.inc';
if (!is_file("select.inc")){
	chdir('../');
}
include_once("select.inc");
$c = new \add_edit_input\Config($config_filename);
$mydb = new MyPDO();
list($response, $rows_count) = \add_edit_input\select($c, $mydb);
echo json_encode($response['Result']);
?>
