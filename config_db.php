<?php
class ConfigDB {
	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $db = "dev";
	public static function get() {
		$that = new ConfigDB();
		return array($that->host, $that->user, $that->pass, $that->db);
	}
}
?>
