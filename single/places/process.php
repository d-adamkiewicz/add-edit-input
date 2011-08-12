<?php
$config_filename = dirname(__FILE__) . '/config.inc';
if (!is_file("process.inc")){
	chdir('../');
}
include_once("process.inc");
$c = new \add_edit_input\Config($config_filename);
$mydb = new MyPDO();
$get = array();
foreach($_GET as $k=>$v){
	$get[$k] = $v;
}
process($c, $mydb, $get);
