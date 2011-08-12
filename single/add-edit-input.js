YUI.add('add-edit-input', function(Y){
	var Widget = Y.Widget,
		YAHOO = Y.YUI2;

	function AddEditInput(config){
		AddEditInput.superclass.constructor.apply(this, arguments);
	}
	AddEditInput.NAME = 'addEditInput';
	AddEditInput.ATTRS = {
		initDataSource: {
			value: null
		},
		inputs: {
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
		script: {
			value: null
		},
		index: {
			value: null
		}
	};
	/* templates */
	AddEditInput.SELECT_TEMPLATE = [
				'<select style="float: left;" id="{id}" name="{id}">',
				'<option value="{value}"{selected}>{text}</option>',
				'</select>'];
	AddEditInput.INPUT_TEMPLATE = [
				'<br clear="left"><div style="float: left; margin: 0.5em 0 0.5em 0;"> \
				<label for="{id}">{label}</label><br><input type="text" size="{size}" id="{id}" name="{id}" value="{valueById}" > \
				</div>'];
	AddEditInput.BUTTON_TEMPLATE = [
				'<br clear="left"><div class="buttons-container">',
				'<span id="{pushbutton}" class="yui-button yui-push-button"><span class="first-child"><input type="button" name="{button}" value="{value}"></span></span>',
			    '</div>'];
	/* --------- */
	Y.extend(AddEditInput, Widget, {
		attrs: {},
		produceMarkup: function(cb, jsonData, inputs) {
			var html = '',
					selectId = jsonData['select']['id'],
					items = jsonData['items'],
					index = jsonData['select']['index'],
					selDef = "",
					buttons = [];

			html += Y.Lang.sub(AddEditInput.SELECT_TEMPLATE[0], {id: selectId});
			Y.each(items, function(v, i) {
				var sSelected = '';
				if (index === i) {
					sSelected = ' selected="selected"';
					selDef = v['inputs'];
				}
				html += Y.Lang.sub(AddEditInput.SELECT_TEMPLATE[1],
					{
						value:		v['option']['value'],
						text:		v['option']['text'],
						selected: 	sSelected
					}
				);
			});
			html += AddEditInput.SELECT_TEMPLATE[2];

			Y.each(inputs, function(v, i) {
				html += Y.Lang.sub(AddEditInput.INPUT_TEMPLATE[0],
					{
						size: 		v['size'],
						id: 		v['id'],
						label:		v['label'],
						valueById: 	selDef && selDef[v['id']]['text']
					}
				);
			});
			html += AddEditInput.BUTTON_TEMPLATE[0];
			Y.each(this.get('buttons'),  function(v, i){
				var btnId  = v['action'] + '-' + cb.get('id');
				buttons.push(btnId);
				html += Y.Lang.sub(AddEditInput.BUTTON_TEMPLATE[1],
						{
							value: 		v['label'],
							button: 	v['action'],
							pushbutton:	btnId
						}
					);
			});
			html += AddEditInput.BUTTON_TEMPLATE[2];
			cb.append(html);
			this.set('items', items);
			this.set('selectId', selectId);
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
				script = self.get('script'),
				index = self.get('index'),
				uri = script + "?action=" + this.get('name') + '&';

			this.set('disabled', true);
			for(var i=0, l=inputs.length;i<l; i++) {
				uri += inputs[i]['id'] + '=' + Y.one('#'+inputs[i]['id']).get('value') + '&';
			}
			var selList = Y.one('#' + self.get('selectId')),
				selVal;
				selList.get('options').each(function(){
					if (this.get('selected')) {
						selVal = this.get('value');
					}
				});
			uri += "selv=" + selVal + "&" + "seli=" + index + "&";
			/***
			 * IMPORTANT - without this line below
			 * IE8/7/6 can't handle utf8 characters ie. central european
			 ***/
			uri = encodeURI(uri);

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
				if (Y.Array.indexOf(parts,'edit') != -1 || Y.Array.indexOf(parts,'delete') != -1){
					this.on('indexChange', function(e){
						var newIndex = e.newVal;
						// no data, disable button
						if (newIndex === ""){
							this.set('disabled', true);
						} else {
							this.set('disabled', false);
						}
					}, this);
				}
			}
			this.set('index', this.attrs['index']);
			Y.one('#' + selectId).on('change', function(e){
				var selIndex = this.get('selectedIndex'),
					items = self.get('items'),
					inputs = self.get('inputs'),
					id;
				self.set('index', selIndex);
				for(var i=0,l=inputs.length; i<l; i++){
					id = inputs[i]['id'];
					Y.one('#' + id).set('value', items[selIndex]['inputs'][id]['text']);
				}
			});

			this.on('itemsChange', function(e){
				var items = e.newVal,
					selectId = this.get('selectId'),
					selectEl = Y.one('#' + selectId),
					index = this.get('index'),
					html = '',
					inputs = this.get('inputs'),
					selDef;


				Y.each(items, function(v2, i) {
					var sSelected = '';
					if (index === i) {
						sSelected = ' selected="selected"';
						selDef = v2['inputs'];
					}
					html += Y.Lang.sub(AddEditInput.SELECT_TEMPLATE[1],
						{
							value:		v2['option']['value'],
							text:		v2['option']['text'],
							selected: 	sSelected
						}
					);
				});
				selectEl.setContent(html);
				// to fix FF bug
				selectEl.set('selectedIndex', index);

				Y.each(inputs, function(v, i){
					Y.one('#' + v['id']).set('value', selDef[v['id']]['text']);
				});
			}, this, true);

		},
		syncUI: function(){

		}
	});
	// crucial
	Y.AddEditInput = AddEditInput;
}, '0.0.11', { requires:['widget', 'datasource', 'io-xdr', 'dump', 'json-parse', 'yui2-button']});
