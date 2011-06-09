<?php
class ConfigDB {
	private $host = "sql2.hekko.net.pl";
	private $user = "rollo_dev";
	private $pass = "dev22dev";
	private $db = "rollo_dev";
	public static function get() {
		$that = new ConfigDB();
		return array($that->host, $that->user, $that->pass, $that->db);
	}
}
?>
