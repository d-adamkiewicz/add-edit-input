YUI.add('add-edit-complex-input', function(Y){
	var Widget = Y.Widget,
		YAHOO = Y.YUI2;
		
	function AddEditComplexInput(config){
		AddEditComplexInput.superclass.constructor.apply(this, arguments);
	}
	AddEditComplexInput.NAME = 'addEditComplexInput';
	AddEditComplexInput.ATTRS = {
		initDataSource: {
			value: null
		}, 
		inputs: {
			value: null
		}, 
		mainSelect: {
			value: null		    
		},
		selectItems: {
			value: null
		},
		checkboxes: {
			value: null
		},
		buttons: {
			value: null
		}, 
		selectId: {
			value: null
		},
		items: {
			value: null
		},
		selects: {
			value: null	
		},
		script: {
			value: null
		}, 
		index: {
			value: null
		}
	};
	/* templates */
	AddEditComplexInput.SELECT_TEMPLATE = [
				'<select style="float: left;" id="{id}" name="{id}"{multiple}{size}>',
				'<option value="{value}"{selected}>{text}</option>',
				'</select>'];
	AddEditComplexInput.INPUT_TEMPLATE = [
				'<br clear="left"><div style="float: left; margin: 0.5em 0 0.5em 0;"> \
				<label for="{id}">{label}</label><br><input type="text" size="{size}" id="{id}" name="{id}" value="{valueById}" > \
				</div>'];
	AddEditComplexInput.CHECKBOX_TEMPLATE = [
				'<label><input id="{id}" type="checkbox"{checked}>{label}</label>'
				];
	AddEditComplexInput.BUTTON_TEMPLATE = [
				'<br clear="left"><div class="buttons-container">',
				'<span id="{pushbutton}" class="yui-button yui-push-button"><span class="first-child"><input type="button" name="{button}" value="{value}"></span></span>',
			    '</div>'];
	/* --------- */
	Y.extend(AddEditComplexInput, Widget, {
		attrs: {},
		produceMarkup: function(cb, jsonData, inputs) {
			var html = '', 
					selectId = jsonData['select']['id'],
					items = jsonData['items'],
					index = jsonData['select']['index'],
					mainSelect = this.get('mainSelect'),
					selects = jsonData["selects"],
					selectItems = this.get('selectItems'),
					checkboxes = this.get('checkboxes'),
					selDef = "",
					buttons = [];
			
			html += Y.Lang.sub(AddEditComplexInput.SELECT_TEMPLATE[0], {id: selectId, multiple: '',size: ' size="'+ mainSelect['size'] + '"'});
			Y.each(items, function(v, i) {
				var sSelected = '';
				if (index === i) {
					sSelected = ' selected="selected"';
					selDef = v['inputs'];
				}
				html += Y.Lang.sub(AddEditComplexInput.SELECT_TEMPLATE[1], 
					{
						value:		v['option']['value'],
						text:		v['option']['text'],
						selected: 	sSelected
					}
				);
			});
			html += AddEditComplexInput.SELECT_TEMPLATE[2];
			
			Y.each(inputs, function(v, i) {
				html += Y.Lang.sub(AddEditComplexInput.INPUT_TEMPLATE[0], 
					{
						size: 		v['size'],
						id: 		v['id'],
						label:		v['label'],
						valueById: 	selDef && selDef[v['id']]['text']
					}
				);
			});
			/*********/
			html += '<br clear="left">';
			Y.each(selectItems, function(v, i) {
				var sSize = v['size'] ? ' size="' + v['size'] +'"' : '', 
					sMultiple = v['multiple'] ? ' multiple="multiple"' : '';
				
				html += '<div style="margin-right: 0.5em; float: left;">';
				html += Y.Lang.sub(AddEditComplexInput.SELECT_TEMPLATE[0], {id: v['id'], size: sSize, multiple: sMultiple});
				var select = selects[v['id']],
						data, elts;
				// "" - no data
				if (index !== "") {
					data = items[index]['indexes'][v['id']];
					elts = v['multiple'] ? data.split(":") : ['' + data];
				}
				Y.each(select, function(v2, i2) {
					var sSelected = '';
					// "" - no data
					if (index !== ""){
						if (Y.Array.indexOf(elts, ''+i2) != -1){
							sSelected = ' selected="selected"';
						}
					}
					html += Y.Lang.sub(AddEditComplexInput.SELECT_TEMPLATE[1], 
						{
							value:		v2['value'],
							text:		v2['text'],
							selected: 	sSelected
						}
					);
				});
				html += AddEditComplexInput.SELECT_TEMPLATE[2];	
				html += '</div>';
			});
			html += '<br clear="left"><br clear="left">';
			/********/
			Y.each(checkboxes, function(v, i){
				var sChecked = '';
				//index === "" - no data
				if (index !== ""){
					if (items[index]['checked'][v['id']]) {
						sChecked = ' checked="checked"';
					}
				}
				html += '<span style="vertical-align: middle; margin-right: 1em;">';
				html += Y.Lang.sub(AddEditComplexInput.CHECKBOX_TEMPLATE[0], {id: v['id'], checked: sChecked, label: v['label']});
				html += '</span>';
			});
			html += '<br clear="left">';
			/********/
			html += AddEditComplexInput.BUTTON_TEMPLATE[0];
			Y.each(this.get('buttons'),  function(v, i){
				var btnId  = v['action'] + '-' + cb.get('id');
				buttons.push(btnId);
				html += Y.Lang.sub(AddEditComplexInput.BUTTON_TEMPLATE[1],
						{ 	
							value: 		v['label'], 
							button: 	v['action'],
							pushbutton:	btnId
						}
					);
			});
			html += AddEditComplexInput.BUTTON_TEMPLATE[2];
			cb.append(html);
			this.set('items', items);
			this.set('selectId', selectId);
			this.set('selects', selects);
			this.attrs['index'] = index;
			this.set('buttons', buttons);
		},
		renderUI: function(){
			var cb = this.get('contentBox');
			var initDS = this.get('initDataSource'),
					inputs = this.get('inputs');
			if (typeof initDS['jsonData'] != "undefined") {
				this.produceMarkup(cb, initDS['jsonData'], inputs);
			} 
		},
		handleButton: function(){
			/*
			*	self - widget object
			*	this - button object
			*/
			var self = arguments[1], 
				inputs = self.get('inputs'),
				checkboxes = self.get('checkboxes'),
				selectItems = self.get('selectItems'),
				script = self.get('script'),
				index = self.get('index'),
				uri = script + "?action=" + this.get('name') + '&';
				
			this.set('disabled', true);
			Y.each(inputs, function(v, i){
				// encodeURIComponent for every input
				uri += v['id'] + '=' + encodeURIComponent(Y.one('#'+ v['id']).get('value')) + '&';	
			});
			Y.each(checkboxes, function(v, i){
				uri += v['id'] + '=' + Y.one('#'+ v['id']).get('checked') + '&';	
			});
			Y.each(selectItems, function(v, i){
				var node = Y.one('#'+ v['id']),
					multi = '', i2 = 0;
				if (v['multiple']){
					node.get('options').each(function(){
						if (this.get('selected')) {
							multi += i2 + ":";
						}
						i2++;
					});
					if (multi){
						multi = multi.substring(0, multi.length-1);
						uri += v['id'] + '=' + multi + '&';	
					//no element selected
					//take first one
					} else  {
						uri += v['id'] + '=' + "0" + '&';	
					}
				} else {
					uri += v['id'] + '=' + node.get('selectedIndex') + '&';	
				}
			});
			var selList = Y.one('#' + self.get('selectId')), 
				selVal;
				selList.get('options').each(function(){
					if (this.get('selected')) {
						selVal = this.get('value');
					}
				});
			uri += "selv=" + selVal + "&" + "seli=" + index + "&";
			
			var callback = {
				on: {
					success: function(x, o, arguments) {
						var messages = {};
						try {
							messages = Y.JSON.parse(o.responseText);
						}
						catch (e) {
							alert("JSON Parse failed!");
							return;
						}
						this.set('index', messages['Result']['select']['index']);
						this.set('items', messages['Result']['items']);
						arguments['btn'].set('disabled', messages['disable-button']);
					},
					failure: function(x, o) {
						alert("Async call failed!");
					}
				}, 
				context: self,
				arguments: {btn: this}
			};
			var request = Y.io(uri, callback);
		},
		bindUI: function(){
			var self = this, 
					buttons = this.get('buttons'),
					selectId = this.get('selectId'),
					index = this.get('index'), 
					parts = [];
			
			for(var i=0, l=buttons.length;i<l; i++) {
				var btn = new YAHOO.widget.Button(buttons[i], {onclick: {fn: this.handleButton, obj: this}});
				parts = buttons[i].split('-');
				// identify button
				if (Y.Array.indexOf(parts,'change') != -1 || Y.Array.indexOf(parts,'delete') != -1){
					this.on('indexChange', function(e){
						var newIndex = e.newVal;
						// no data, disable button
						if (newIndex === ""){
							this.set('disabled', true);
						} else {
							this.set('disabled', false);
						}
					}, btn);
				}	
			}
			this.set('index', this.attrs['index']);
			Y.one('#' + selectId).on('change', function(e){
				var selIndex = this.get('selectedIndex'),
					items = self.get('items'),
					inputs = self.get('inputs'),
					selectItems = self.get('selectItems'),
					checkboxes = self.get('checkboxes'),
					id;
				self.set('index', selIndex);
				Y.each(inputs, function(v, i){
					Y.one('#' + v['id']).set('value', items[selIndex]['inputs'][v['id']]['text']);
				});
				Y.each(selectItems, function(v, i){
					var data = items[selIndex]['indexes'][v['id']],
						node = Y.one('#' + v['id']);
					if (v['multiple']){
						var elts = data.split(":"),
							i2 = 0;
						node.get('options').each(function(){
							// clear all
							this.set('selected', false);
							/*
							it MUST BE the same value type
							notice: ''+i2
							*/
							if (Y.Array.indexOf(elts, ''+i2) != -1){
								/*
								 * use of console.log causes problems in non-debugging mode in IE8/9
								 */
								//console.log(elts+" "+i2);
								this.set('selected', true);
							}
							i2++;
						});	
					} else {
						node.set('selectedIndex', data);
					}
				});
				Y.each(checkboxes, function(v, i){
					Y.one('#' + v['id']).set('checked', items[selIndex]['checked'][v['id']]);
				});
			});
			
			this.on('itemsChange', function(e){
				var items = e.newVal,
					selectId = this.get('selectId'),
					selectEl = Y.one('#' + selectId),
					index = this.get('index'),
					selDef = '', html = '',
					inputs = this.get('inputs'),
					selectItems = this.get('selectItems'),
					checkboxes = this.get('checkboxes');
				
				
				Y.each(items, function(v, i) {
					var sSelected = '';
					if (index === i) {
						sSelected = ' selected="selected"';
						selDef = v['inputs'];	
					}
					html += Y.Lang.sub(AddEditComplexInput.SELECT_TEMPLATE[1], 
						{
							value:		v['option']['value'],
							text:		v['option']['text'],
							selected: 	sSelected
						}
					);
				});
				selectEl.setContent(html);
				// to fix FF bug
				selectEl.set('selectedIndex', index);
				
				Y.each(inputs, function(v, i){
					Y.one('#' + v['id']).set('value', selDef && selDef[v['id']]['text']);
				});
				
				Y.each(selectItems, function(v, i){
					// index is 'selectedIndex' of selectEl
					// "" - no data
					var idx = (index === "" ? 0 : index),
						data = items[idx]['indexes'][v['id']],
						node = Y.one('#' + v['id']);
					if (v['multiple']) {
						var elts = data.split(":"),
								i2 = 0;
						node.get('options').each(function(){
							// clear all
							this.set('selected', false);
							/*
							it MUST BE the same value type
							notice: ''+i2
							*/
							if (Y.Array.indexOf(elts, ''+i2) != -1){
								//console.log(elts+" "+i2);
								this.set('selected', true);
							}
							i2++;
						});	
					} else {
						node.set('selectedIndex', data);
					}
				});
				/**********/
				Y.each(checkboxes, function(v, i){
					// index is 'selectedIndex' of selectEl
					// "" - no data
					var idx = (index === "" ? 0 : index),
						data = items[idx]['checked'][v['id']],
						node = Y.one('#' + v['id']);
					node.set('checked', data);	
				});
				/**********/
			}, this, true);
			
		},
		syncUI: function(){
			
		}
	});
	// crucial
	Y.AddEditComplexInput = AddEditComplexInput;
}, '0.0.7', { requires:['widget', 'datasource', 'io-xdr', 'dump', 'json-parse', 'yui2-button']});
