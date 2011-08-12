<?php
//v0.3
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

function as_ref($arr){
    $refs = array();
    foreach($arr as $key => $value)
        $refs[$key] = &$arr[$key];
    return $refs;
}

function process($c, $mydb, $get){
	$disable_button = TRUE;
	$rows_count = \add_edit_input\rows_count($c, $mydb);

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
			$rv = call_user_func_array(
				array($sth, "bindParam"),
				/***
				* as in php5.3 second parameter to 'call_user_func_array' 
				* must be array of referenced values (not values itself)
				***/
				as_ref(array_merge(
					array(":" . $item['tb']['name'], $get[$item['pg']['name']]),
				// notice (array) cast
					(array)$item['pg']['pdo_def']
					)
				)
			);
			if (!$rv){
				write_log('failed to pass parameters to "bindParam"', 'process.log');
			}
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

		list($response, $rows_count) = \add_edit_input\select($c, $mydb);
		$disable_button = FALSE;
	} else if (strpos($get['action'], 'edit') !== FALSE) {
		$map = \add_edit_input\index2id($c, $mydb);
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

		list($response, $rows_count) = \add_edit_input\select($c, $mydb);
		$disable_button = FALSE;
	} else if (strpos($get['action'], 'delete') !== FALSE) {
		$map = \add_edit_input\index2id($c, $mydb);
		$id = $map[$get['seli']];

		write_log("\$id: " . $id, 'process.log');

		$sql = get_require('delete_sql_main_tpl.php', $c);
		write_log($sql, 'process.log');		


		$sth = $mydb->prepare($sql);
		$sth->bindParam(":{$c->prefix()}_id", $id, PDO::PARAM_INT);
		
		write_log("\$sth: " . var_export($sth, TRUE), 'process.log');

		try {
			$rc = $sth->execute();
		} catch(PDOException $e){
			write_log($e->getMessage(), 'process.log');
			exit(1);
		}
		$rows_count -= $rc;
		write_log("records deleted: " . $rc . " records left: " . $rows_count, 'process.log');		

		$sql = get_require('update_sql_param_tpl.php', $c);

		write_log("sql_param_update: " . $sql);

		$sth = $mydb->prepare($sql);

		if ($rows_count==0) {

			$index = $id = NULL;

		} else if ($rows_count>0){

			$index = $get['seli'];
			if ($index < $rows_count){
				$s_index = $index + 1;
			} else {
				$s_index = $index - 1;
				$index--;
			}
			$id = $map[$s_index];

		}

		$sth->bindParam(":{$c->prefix()}_index", $index, PDO::PARAM_INT);
		$sth->bindParam(":{$c->prefix()}_foreign_id", $id, PDO::PARAM_INT);

		try {
			$sth->execute();
		} catch(PDOException $e){
			write_log($e->getMessage(), 'process.log');
			exit(1);
		}

		list($response, $rows_count) = \add_edit_input\select($c, $mydb);
		$disable_button = FALSE;
	}
	echo json_encode($response + array('disable-button'=>$disable_button));
}
?>
