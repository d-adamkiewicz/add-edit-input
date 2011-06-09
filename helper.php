<?php
if (!function_exists("preprint")){
	function preprint($s, $return=false) {
		$x = "<pre>";
		$x .= print_r($s, 1);
		$x .= "</pre>";
		if ($return) return $x;
		else print $x;
	}
}

if (!function_exists("get_require")){
	function get_require($filename, $conf){
		if (is_file($filename)){
			ob_start();
			require $filename;
			return ob_get_clean();
		}
		return $false;
	}
}
?>
