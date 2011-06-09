<?php
include_once('config.php');
include_once('mypdo.php');
include_once('helper.php');
include_once('select.inc');
/**
* 'select.inc' include(s)_once 'debug.php'
* but just in case of future changes...
*/
include_once('debug.php');
/**
* if you want to turn off saving messages to a log file 
* set GLOBAL variable $write_log to FALSE ie:
* $write_log = FALSE;
*/

function process($c, $mydb, $get){
	$rows_count = rows_count($c, $mydb);

	write_log("\$rows_count: " . $rows_count, 'process.log');

	$items = $c->items();

	write_log("\$get['action']: " . $get['action'], 'process.log');
	if (strpos($get['action'], 'add') !== FALSE) {

		$sql = get_require('insert_sql_main_tpl.php', $c);
		$sth = $mydb->prepare($sql);
		foreach($items as $item) {
			/***
			* because $item['pg']['pdo_def'] can be 1 or 2 element "array" (part of array)
			* in order to pass an array as argument list to
			* $sth->bindParam we must use 'call_user_func_array()'
			***/
			call_user_func_array(
				array($sth, "bindParam"),
				// notice (array) cast
				array_merge(array(":" . $item['tb']['name'], $get[$item['pg']['name']]),  (array)$item['pg']['pdo_def'])
			);
		}

		try {
			$sth->execute();
		} catch(PDOException $e){
			/**
			* write_log($message, [$file='file.log', [$adddate=TRUE ]]);
			*/	
			write_log($e->getMessage(), 'process.log');
			exit(1);
		}

		$sth->rowCount();
		$id = $mydb->lastInsertId();

		write_log("\$id: " . $id, 'process.log');

		$sql = get_require('update_sql_param_tpl.php', $c);

		write_log("sql_param_update: " . $sql, 'process.log');

		$sth = $mydb->prepare($sql);
		$sth->bindParam(":" . $c->prefix() . "_index", $rows_count, PDO::PARAM_INT);
		$sth->bindParam(":" . $c->prefix() . "_foreign_id", $id, PDO::PARAM_INT);

		write_log("\$sth: " . var_export($sth, TRUE), 'process.log');

		try {
			$sth->execute();
		} catch(PDOException $e){
			write_log($e->getMessage(), 'process.log');
			exit(1);
		}

		list($response, $rows_count) = select($c, $mydb);
	} else if (strpos($get['action'], 'edit') !== FALSE) {
		$map = index2id($c, $mydb);
		$id = $map[$get['seli']];

		write_log("\$id: " . $id, 'process.log');
		
		$sql = get_require("update_sql_main_tpl.php", $c);

		write_log("sql_main_update: " . $sql, 'process.log');

		$sth = $mydb->prepare($sql);

		foreach($items as $item) {
			$sth->bindParam(":{$item['tb']['name']}", $get[$item['pg']['name']]);
		}
		$sth->bindParam(":{$c->prefix()}_id", $id, PDO::PARAM_INT);

		try {
			$sth->execute();
		} catch(PDOException $e){
			write_log($e->getMessage(), 'process.log');
			exit(1);
		}
		
		$sql = get_require('update_sql_param_tpl.php', $c);

		write_log("sql_param_update: " . $sql);

		$sth = $mydb->prepare($sql);
		$sth->bindParam(":{$c->prefix()}_index", $get['seli'], PDO::PARAM_INT);
		$sth->bindParam(":{$c->prefix()}_foreign_id", $id, PDO::PARAM_INT);

		write_log("\$sth: " . var_export($sth, TRUE), 'process.log');

		try {
			$sth->execute();
		} catch(PDOException $e){
			write_log($e->getMessage(), 'process.log');
			exit(1);
		}

		list($response, $rows_count) = select($c, $mydb);
	}
	echo json_encode($response);
}
?>
