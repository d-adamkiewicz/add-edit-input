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
<div id="folks-container"></div>
<!--<br clear="left">-->
<div id="places-container"></div>
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
		boundingBox: '#folks-container'
		//, width: "10em"
		, inputs: [
			{size: "16", id: "person-fname", label: "First name"},
			{size: "24", id: "person-lname", label: "Last name"},
			{size: "2", id: "person-age", label: "Age"}
		]
		, initDataSource: {jsonData:<?php include_once("./folks/select.php"); ?>}
		, buttons: [
			{label: 'Add', action: 'add-pers-data'},
			{label: 'Edit', action: 'edit-pers-data'}
		]
		, script: 'folks/process.php'
	});
	addEditInput.render();

	var addEditInput2 = new Y.AddEditInput({
		boundingBox: '#places-container'
		//, width: "10em"
		, inputs: [
			{size: "16", id: "city", label: "City"},
			{size: "8", id: "pocode", label: "Postal code"},
			{size: "16", id: "country", label: "Country"}
		]
		, initDataSource: {jsonData:<?php include_once("./places/select.php"); ?>}
		, buttons: [
			{label: 'Add', action: 'add-branch-data'},
			{label: 'Edit', action: 'edit-branch-data'}
		]
		, script: 'places/process.php'
	});
	addEditInput2.render();
});
</script>
</body>
</html>
