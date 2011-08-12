<?php
namespace add_edit_input;

include_once("config.php");
include_once("helper.php");
include_once("mypdo.php");
include_once("debug.php");
/**
* if you want to turn off saving messages to a log file 
* set GLOBAL variable $write_log to FALSE ie:
* $write_log = FALSE;
*/

function select($c, $mydb){
	//echo $c->dirname(), "<br>";
	$sql = get_require('select_sql_main_tpl.php', $c);
	//preprint($sql);
	try {
		$rv = $mydb->query($sql);
	} catch(PDOException $e){
		/**
		* write_log($message, [$file='file.log', [$adddate=TRUE ]]);
		*/	
		write_log($e->getMessage(), 'select.log');
		exit(1);
	}

	$items[] = array("option"=>array("value"=>"", "text"=>""));
	foreach($c->items() as $v){
		$items[0]['inputs'][$v['pg']['name']] = array("text"=>"");
	}
	$def = array();
	$rows_count = 0;
	while($row = $rv->fetch()){
		$def[$row['rownum']] = $row[$c->prefix() . "_id"];
		$items[$rows_count] = array("option"=>array("value"=>$row['rownum']));
		foreach($c->items() as $v){
			$items[$rows_count]['inputs'][$v['pg']['name']] = array("text"=>$row[$v['tb']['name']]);
			$items[$rows_count]['option']['text'] .= $row[$v['tb']['name']] . " ";
		}
		$items[$rows_count]['option']['text'] = chop($items[$rows_count]['option']['text']);
		$rows_count++;
	}

	$select = array(
			"id"=>"select-" . $c->prefix(),
			// "" or NULL means no data
			"index"=>""
		);

	$sql = get_require('select_sql_param_tpl.php', $c);

	try {
		$rv = $mydb->query($sql);
	} catch(PDOException $e){
		write_log($e->getMessage(), 'select.log');
		exit(1);
	}

	$rows = $rv->fetchAll();
	$check_count = count($rows);
	if ($check_count != 1) {
		die("number of rows in " . $conf->table . "_bind is: " . $check_count . " - should be 1!!!");
	} else if ($check_count == 1) {
		if ($rows[0][$c->prefix() . "_index"] != NULL) {
			$select['index'] = (int)$rows[0][$c->prefix() . "_index"];
		}
	}
	
	$response = array("Result"=>array(
		"items"=>$items,
		"select"=>$select
		)
	);
	return array($response, $rows_count);
}	

function rows_count($c, $mydb){
	$sql = "SELECT COUNT(*) FROM {$c->table()}";

	try {
		$rv = $mydb->query($sql);
	} catch(PDOException $e){
		write_log($e->getMessage(), 'select.log');
		exit(1);
	}

	return $rv->fetchColumn();
}

function index2id($c, $mydb){
	$sql = "SELECT @rownum:=@rownum+1 AS rownum, {$c->prefix()}_id 
		FROM (SELECT {$c->prefix()}_id FROM {$c->table()} ORDER BY {$c->prefix()}_id) v, (SELECT @rownum:=-1) r";

	try {
		$rv = $mydb->query($sql);
	} catch(PDOException $e){
		write_log($e->getMessage(), 'select.log');
		exit(1);
	}

	$map = array();
	// notice: thanks to \ is global constant
	while($row = $rv->fetch(\PDO::FETCH_ASSOC)){
		$map[$row['rownum']] = $row["{$c->prefix()}_id"];	
	}

	return $map;
}
?>
