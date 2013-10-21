// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.htdocumentlibrary', {
		// creates control instances based on the control's id.
		// our button's id is "htdocumentlibrary_button"
		createControl : function(id, controlManager) {
			if (id == 'htdocumentlibrary_button') {
				// creates the button
				var button = controlManager.createButton('htdocumentlibrary_button', {
					title : 'htdocumentlibrary Shortcode', // title of the button
					image : '../wp-includes/images/crystal/document.png',  // path to the button's image
					onclick : function() {
						// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 280 < width ) ? 280 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'My Gallery Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=htdocumentlibrary-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('htdocumentlibrary', tinymce.plugins.htdocumentlibrary);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="htdocumentlibrary-form"><table id="htdocumentlibrary-table" class="form-table">\
			<tr>\
				<th><label for="htdocumentlibrary-category">Category</label></th>\
				<td><input type="text" id="htdocumentlibrary-columns" name="category" value="3" /><br />\
				<small>Which category to list?</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="htdocumentlibrary-submit" class="button-primary" value="Insert document listing" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#htdocumentlibrary-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'cat'    : '',
				};
			var shortcode = '[documentlibrary';
			
			for( var index in options) {
				var value = table.find('#htdocumentlibrary-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()