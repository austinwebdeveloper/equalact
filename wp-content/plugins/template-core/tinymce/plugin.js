(function($) {
"use strict";   			
		// create Tpath Shortcodes plugin
		tinymce.PluginManager.add( 'tpathShortcodes', function( editor, url ) {
			
			editor.addCommand("tpathPopup", function ( a, params )
			{
				var popup = 'tpath-sc-generator';

				if(typeof params != 'undefined' && params.identifier) {
					popup = params.identifier;
				}
				
				tb_show("Template Path Shortcodes", ajaxurl + "?action=tpath_shortcodes_popup&popup=" + popup);
				jQuery('#TB_window').hide();
			});
 
			editor.addButton( 'tpath_button', {
				text: '',
				icon: true,
				image: TpathShortcodes.plugin_folder +"/tinymce/images/icon.png",				
				cmd: 'tpathPopup'			
		  	});
	 
	  }); 
})(jQuery);