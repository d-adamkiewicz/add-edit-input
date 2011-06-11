<?php
return array(
	'items'=>array(
		array('pg'=>array('name'=>'city', 'pdo_def'=>array(PDO::PARAM_STR, 24)),'tb'=>array('col_def'=>'CHAR(24)')),
		array('pg'=>array('name'=>'country', 'pdo_def'=>array(PDO::PARAM_STR, 16))),
		array('pg'=>array('name'=>'pocode', 'pdo_def'=>array(PDO::PARAM_STR, 8)))
	),
	/**
	* 'table' or 'prefix' must be set (or both)
	* if only 'prefix' is set table name is constructed by adding 's' at the end
	* 'prefix'"s" 
	**/
	'table'=>'address'
	//'prefix'=>'addr'
);
?>
