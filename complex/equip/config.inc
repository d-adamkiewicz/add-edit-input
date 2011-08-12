<?php
return array(
	'items'=>array(
		array('pg'=>array('name'=>'name', 'pdo_def'=>array(PDO::PARAM_STR, 16)))
		/**
		* if 'tb' array is omitted it's assumed it's (almost) the same as 'pg' 
		* 'col_def' defaults: 
		* PDO_PARAM_STR is VARCHAR
		* PDO_PARAM_INT is SMALLINT
		* TDO: 'defaults' array can change that
		*/
	),
	'foreign'=>array(
		// hardcoded path
		array('path'=>'/../single/folks/config.inc'),
		array('path'=>'/../single/places/config.inc', 'multiple'=>TRUE),
	),
	/**
	* 'table' or 'prefix' must be set (or both)
	* if only 'prefix' is set table name is constructed by adding 's' at the end
	* 'prefix'"s" 
	**/
	//'table'=>'people'
	'prefix'=>'equip'
);
?>
