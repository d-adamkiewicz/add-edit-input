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
					echo '<div style="float: left; width: 10em;"><b>table:</b> '
							. $c->table() . '</div><div style="float: left; width: 10em;"><b>prefix:</b> '
							. $c->prefix() . '</div><br clear="left">';
					
					echo '<div style="float: left; width: 10em;"><b>pg name:</b> 
						</div><div style="float: left; width: 10em;"><b>pdo_def length:</b>
						</div><div style="float: left; width: 10em;"><b>tb name:</b>
						</div><div style="float: left; width: 20em;"><b>col_def:</b>
						</div><br clear="left">';
					foreach($c->items() as $v){
						echo '<div style="float: left; width: 10em;">'
							. $v['pg']['name'] . '</div><div style="float: left; width: 10em;">'
							. ($v['pg']['pdo_def'][1]?$v['pg']['pdo_def'][1]:1) . '</div><div style="float: left; width: 10em;">'
							. $v['tb']['name'] . '</div><div style="float: left; width: 20em;">'
							. $v['tb']['col_def'] . '</div><br clear="left">';
					}
				}
			}
		}
	}
}
?>
