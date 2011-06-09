<?php
return array(
	'items'=>array(
		array('pg'=>array('name'=>'unit', 'pdo_def'=>array(PDO::PARAM_STR, 128)),'tb'=>array('col_def'=>'CHAR(128)')),
		array('pg'=>array('name'=>'descr', 'pdo_def'=>array(PDO::PARAM_STR, 255)))
	),
	/**
	* 'table' or 'prefix' must be set (or both)
	* if only 'prefix' is set table name is constructed by adding 's' at the end
	* 'prefix'"s" 
	**/
	'table'=>'units'
	//'prefix'=>'unit'
);
?>
