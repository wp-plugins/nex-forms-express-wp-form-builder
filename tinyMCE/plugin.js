(function(){
	tinymce.create('tinymce.plugins.aforms', {
		init : function(ed, url){
			ed.addButton('aforms', {
				title	: 'Insert Form',
				image	: url + '/button.png',
				cmd		: 'popup_window'
			});
			
			ed.addCommand('Add_shortcode', function(){
				ilc_sel_content = tinyMCE.activeEditor.selection.getContent();
				tinyMCE.activeEditor.selection.setContent('[AForms]');
			});
			
			ed.addCommand('popup_window', function(){
				ed.windowManager.open({
					file 		: ajaxurl + '?action=NEXFormsExpress_tinymce_window',
					width 		: 400,
					height 		: 150,
					inline 		: 1
				}, {
					plugin_url 	: url // Plugin absolute URL
				});
			});
		},
	});
tinymce.PluginManager.add('aforms', tinymce.plugins.aforms);
})();