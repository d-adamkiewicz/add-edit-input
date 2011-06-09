<?php
include_once('config.php');
include_once('helper.php');
$dir_handle = opendir('./');
$pattern = '/^\.{1,2}$/';
while(false !== ($file = readdir($dir_handle))){
	if (is_dir($file)){
		if (!preg_match($pattern, $file)){
			$subdir_handle = opendir("./$file");
			while(false !==($sfile = readdir($subdir_handle))){
				if (preg_match('/^config\.inc$/', $sfile)){
					$c = new Config("./$file/$sfile");
					/*
					$c->basename();
					$c->table();
					$c->prefix();
					*/
					echo "./$file/$sfile" . "<br>";
					echo '<div style="float: left; width: 10em;">table: '
							. $c->table() . '</div><div style="float: left; width: 10em;">prefix: '
							. $c->prefix() . '</div><br clear="left">';
					foreach($c->items() as $v){
						echo '<div style="float: left; width: 10em;">pg name: '
							. $v['pg']['name'] . '</div><div style="float: left; width: 10em;">tb name: '
							. $v['tb']['name'] . '</div><div style="float: left; width: 20em;">col_def: '
							. $v['tb']['col_def'] . '</div><br clear="left">';
					}
				}
			}
		}
	}
}
?>
