<?php
namespace add_edit_input;
class Config{
	protected $table;
	protected $prefix;
	protected $items;
	protected $dirname;

	function __construct($path){
		$this->dirname = dirname($path);
		$c = require $path;
		$tb_prefix = $pg_prefix = "";
		if (isset($c['table']) || isset($c['prefix'])){
			$this->table = isset($c['table']) ? $c['table'] : ($c['prefix'] . "s");
			$this->prefix = isset($c['prefix'])?$c['prefix']:'';
			if ($this->prefix) {
				$tb_prefix = $this->prefix . "_";
				$pg_prefix = $this->prefix . "-";
			}
		} else {
			die("Error:...");	
		}
		foreach($c['items'] as &$item) {
			// in order to prevent 'Undefined index: ...' warning
			$item['tb'] = isset($item['tb']) ? $item['tb'] : '';
			$item['tb']['name'] = isset($item['tb']['name']) ? $item['tb']['name'] : '';

			// order matters
			$item['tb']['name'] =  $tb_prefix . ($item['tb']['name'] ? $item['tb']['name'] : $item['pg']['name']);
			if (!isset($item['tb']['col_def'])){
				switch($item['pg']['pdo_def'][0]){
					case \PDO::PARAM_STR:
						$item['tb']['col_def'] = "VARCHAR(" . ($item['pg']['pdo_def'][1]?$item['pg']['pdo_def'][1]:"255") . ")"; 
					break;
					case \PDO::PARAM_INT:
						$item['tb']['col_def'] = "INT";
					break;
				}
			}
			$item['pg']['name'] =  $pg_prefix . $item['pg']['name'];
		}
		$this->items = $c['items'];
	}
	function table(){
		return $this->table;
	}
	function prefix(){
		return $this->prefix;
	}
	function items(){
		return $this->items;
	}
	function dirname(){
		return $this->dirname;
	}
}
?>
