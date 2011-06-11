<?php
return array(
	'items'=>array(
		array('pg'=>array('name'=>'fname', 'pdo_def'=>array(PDO::PARAM_STR, 16)), 'tb'=>array('name'=>'dep','col_def'=>'VARCHAR(16)')),
		/**
		* if 'tb' array is omitted it's assumed it's (almost) the same as 'pg' 
		* 'col_def' defaults: 
		* PDO_PARAM_STR is VARCHAR
		* PDO_PARAM_INT is SMALLINT
		* TDO: 'defaults' array can change that
		*/
		array('pg'=>array('name'=>'lname', 'pdo_def'=>array(PDO::PARAM_STR, 32))),
		array('pg'=>array('name'=>'age', 'pdo_def'=>array(PDO::PARAM_INT)))
	),
	/**
	* 'table' or 'prefix' must be set (or both)
	* if only 'prefix' is set table name is constructed by adding 's' at the end
	* 'prefix'"s" 
	**/
	//'table'=>'people'
	'prefix'=>'person'
);
?>
