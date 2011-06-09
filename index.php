<?php include_once('paths.inc'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<link type="text/css" rel="stylesheet" href="<?php echo $root_path; ?>/vendor/yui_3.3.0/build/cssfonts/fonts-min.css">
<link type="text/css" rel="stylesheet" href="<?php echo $root_path; ?>/vendor/yui_3.3.0/build/cssgrids/grids-min.css">
<style type="text/css">
body {
	width: 950px;
	margin: auto;
}
#menu-button {
	margin: 5px 0 5px 0;
}
.yui3-addeditinput {
	background: #cdcdcd;
	padding: 4px;
	display: block;
	float: left;
	margin-right: 0.5em;
}
#addeditinput-btns {
	/*float: left;*/
	margin: 0.5em 0 0.5em 0;
}
</style>
<script type="text/javascript" src="<?php echo $root_path; ?>/vendor/yui_3.3.0/build/yui/yui-min.js"></script>
</head>
<body class="yui3-skin-sam  yui-skin-sam">
<div id="depart-container"></div>
<div id="branch-container"></div>
<script type="text/javascript">
YUI({
	base:'<?php echo $root_path; ?>/vendor/yui_3.3.0/build/',
	groups: {
        yui2: {
            base: '<?php echo $root_path; ?>/vendor/yui-2in3/dist/2.9.0/build/',

            // If you have a combo service, you can configure that as well
            // combine: true,
            // comboBase: 'http://myserver.com/combo?',
            // root: '/2in3/build/',

            patterns:  {
                'yui2-': {
                    configFn: function(me) {
                        if(/-skin|reset|fonts|grids|base/.test(me.name)) {
                            me.type = 'css';
                            me.path = me.path.replace(/\.js/, '.css');
                            me.path = me.path.replace(/\/yui2-skin/, '/assets/skins/sam/yui2-skin');
                        }
                    }
                }
            }
        }
    },
	modules: {
		'add-edit-input': {
			fullpath: 'add-edit-input.js',
			requires: ['widget', 'datasource', 'io-xdr', 'dump', 'json-parse',  'yui2-button']
		}
	}
	//, filter: 'raw'
}).use('yui2-button', 'add-edit-input', function(Y){
	var Widget = Y.Widget,
			YAHOO = Y.YUI2;
	var addEditInput = new Y.AddEditInput({
		boundingBox: '#zona-container'
		//, width: "10em"
		, inputs: [
			{size: "30", id: "dep-department", label: "Name"},
			{size: "40", id: "dep-descr", label: "Description"},
			{size: "2", id: "dep-counts", label: "Liczba"}
		]
		, initDataSource: {jsonData:<?php include_once("./depart/select.php"); ?>}
		, buttons: [
			{label: 'Dodaj', action: 'add-dep-data'},
			{label: 'Zmień', action: 'edit-dep-data'}
		]
		, script: 'dzial/process.php'
		//initDataSource: {script:'emit_json.php'}
	});
	addEditInput.render();

	var addEditInput2 = new Y.AddEditInput({
		boundingBox: '#branch-container'
		//, width: "10em"
		, inputs: [
			{size: "10", id: "unit", label: "Name"},
			{size: "20", id: "descr", label: "Description"}
		]
		, initDataSource: {jsonData:<?php include_once("./branch/select.php"); ?>}
		, buttons: [
			{label: 'Dodaj', action: 'add-branch-data'},
			{label: 'Zmień', action: 'edit-branch-data'}
		]
		, script: 'komorka/process.php'
		//initDataSource: {script:'emit_json.php'}
	});
	addEditInput2.render();
});
</script>
</body>
</html>
