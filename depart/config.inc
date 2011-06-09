<?php
return array(
	'items'=>array(
		array('pg'=>array('name'=>'department', 'pdo_def'=>array(PDO::PARAM_STR, 30)), 'tb'=>array('name'=>'dep','col_def'=>'VARCHAR(30)')),
		/**
		* if 'tb' array is omitted it's assumed it's (almost) the same as 'pg' 
		* 'col_def' defaults: 
		* PDO_PARAM_STR is VARCHAR
		* PDO_PARAM_INT is SMALLINT
		* TDO: 'defaults' array can change that
		*/
		array('pg'=>array('name'=>'descr', 'pdo_def'=>array(PDO::PARAM_STR,255))),
		array('pg'=>array('name'=>'counts', 'pdo_def'=>array(PDO::PARAM_INT)))
	),
	/**
	* 'table' or 'prefix' must be set (or both)
	* if only 'prefix' is set table name is constructed by adding 's' at the end
	* 'prefix'"s" 
	**/
	//'table'=>'deps'
	'prefix'=>'dep'
);
?>
