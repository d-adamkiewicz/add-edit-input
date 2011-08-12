<?php include_once('paths.inc'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!-- ADD and CHANGE WORKS (NOT FULLY TESTED) -->
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
<div id="menu-button">
<span id="linkbutton-godata" class="yui-button yui-link-button">
    <span class="first-child">
    <a href="./index.php">Parametry</a>
    </span>
</span>
<span id="linkbutton-gosearch" class="yui-button yui-link-button">
    <span class="first-child">
        <a href="./search.php">Wyszukiwarka</a>
    </span>
</span>
</div>
<div id="apartdata-container"></div>
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
		'add-edit-complex-input': {
			fullpath: 'add-edit-complex-input.js',
			requires: ['widget', 'datasource', 'io-xdr', 'dump', 'json-parse',  'yui2-button']
		}
	}
	//, filter: 'raw'
}).use('yui2-button', 'add-edit-complex-input', function(Y){
	var Widget = Y.Widget,
			YAHOO = Y.YUI2;
	var addEditComplexInput = new Y.AddEditComplexInput({
		boundingBox: '#apartdata-container'
		//, width: "10em"
		, mainSelect: {size: "10"}
		, inputs: [
			{size: "50", id: "equip-name", label: "Nazwa"}
		]
		, selectItems: [
			{id: "select-persons"},
			{id: "select-address", size: "5", multiple: true}
		]
		, initDataSource: { jsonData:<?php include_once("./equip/select.php"); ?> }
		, buttons: [
			{label: 'Dodaj', action: 'add-apartdata-data'}, 
			{label: 'Zmień', action: 'edit-apartdata-data'},
			{label: 'Usuń', action: 'delete-apartdata-data'}
			
		],
		script: './equip/process.php'
	});
	addEditComplexInput.render();
	var oLinkBtnGoData = new YAHOO.widget.Button("linkbutton-godata"),
			oLinkBtnGoSearch = new YAHOO.widget.Button("linkbutton-gosearch");
	
});
</script>
</body>
</html>
