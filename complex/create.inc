<?php
include_once("config.php");
include_once("mypdo.php");
include_once("helper.php");

$mydb = new MyPDO();
$conf = new Config($config_filename);

$sth = $mydb->prepare('SELECT COUNT(*) 
			FROM information_schema.tables
			WHERE table_schema = :databasename
			AND table_name = :tablename');
try {
	$sth->execute(array(':databasename'=>$mydb->dbname(), ':tablename'=>$conf->table()));		
} catch(PDOException $e) {
	echo $e->getMessage();
	exit(1);
}

if ($sth->fetchColumn() == 1){
	echo "Table " . $conf->table() . " already exists!<br>";
} else {
	$sql_main = get_require('create_sql_main_tpl.php', $conf);
	try {
		$mydb->query($sql_main); 
	} catch(PDOException $e) {
		echo $e->getMessage();
		exit(1);
	}
	preprint($sql_main);
}

try {
	$sth->execute(array(':databasename'=>$mydb->dbname(), ':tablename'=>$conf->table() . "_bind"));	
} catch(PDOException $e) {
	echo $e->getMessage();
	exit(1);
}

if ($sth->fetchColumn() == 1){
	echo "Table " . $conf->table() . "_bind already exists!<br>";
} else {
	$sql_param = get_require('create_sql_param_tpl.php', $conf);
	try { 
		$mydb->query($sql_param); 
	} catch(PDOException $e) {
		echo $e->getMessage();
		exit(1);
	}
	preprint($sql_param);

	$sql_param = get_require('insert_sql_param_tpl.php', $conf);
	try {
		$mydb->query($sql_param);
	} catch(PDOException $e) {
		echo $e->getMessage();
		exit(1);
	}
	preprint($sql_param);
}
?>
