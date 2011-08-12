<?php
include_once('config_db.php');
class MyPDO extends PDO
{
	private $dbname;
	public function __construct() {
		list($host, $user, $pass, $db) = ConfigDB::get();
		$this->dbname = $db;
		try {
			parent::__construct(
				"mysql:host=$host;dbname=$db", 
				$user, 
				$pass, 
			/**
			 * IMPORTANT in order to force to set encodings for CRUD operations to utf8
			 * PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		 	 */
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
			/**
			 * IMPORTANT if you want use try{}catch(){}
			 */
				+ array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION)
			);
		} catch (PDOException $e) {
			echo "Error!:", $e->getMessage();
		}
	}
	function dbname(){
		return $this->dbname;
	}
}
?>
