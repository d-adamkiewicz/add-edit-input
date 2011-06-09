<?php
 /*
 *  in order to switch on/off log writing
 */
$write_log = TRUE;

function get_localtime_string() {
	$lctime = localtime();
	$ldate  = sprintf("%02d-%02d-%4d %02d:%02d:%02d",
		$lctime[3],             // day of the month
		$lctime[4] + 1,         // month of the year
		$lctime[5] + 1900,      // years since 1900
		$lctime[2],             // hour
		$lctime[1],             // minutes
		$lctime[0]              // seconds
	);
	return $ldate;
}

function write_log($message, $logfile = "./file.log", $addtime = TRUE) {

	global $write_log;

	if ($write_log) {	
		if (($fh = fopen($logfile, "a+")) === FALSE) {
			echo "<b>error opening file: $logfile with mode: a+</b><br />";
		}

		if ($addtime === TRUE) {
			//$message = get_localtime_string() . " / " . gmdate("d-m-Y H:i:s", time() + (2 * 60 * 60)) . ": " . $message;
			$message = get_localtime_string() . ", " . gmdate("H:i:s", time() + (2 * 60 * 60)) . ": " . $message;
		}

		if (($retval = fwrite($fh, $message . "\n")) === FALSE) {
			echo "<b>error writing message: $message to a log file: $logfile</b><br />";
		}

		fclose($fh);
	}
}
?>
