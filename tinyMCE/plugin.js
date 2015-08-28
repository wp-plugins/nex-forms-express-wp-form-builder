(function(){
	tinymce.create('tinymce.plugins.nexforms', {
		init : function(ed, url){
			ed.addButton('nexforms', {
				title	: 'Insert NEX Form',
				image	: url + '/button.png',
				cmd		: 'popup_window'
			});
			
			ed.addCommand('Add_shortcode', function(){
				ilc_sel_content = tinyMCE.activeEditor.selection.getContent();
				tinyMCE.activeEditor.selection.setContent('[NEXForms]');
			});
			
			ed.addCommand('popup_window', function(){
				ed.windowManager.open({
					file 		: ajaxurl + '?action=NEXForms_tinymce_window',
					width 		: 400,
					height 		: 270,
					inline 		: 1
				}, {
					plugin_url 	: url // Plugin absolute URL
				});
			});
		},
	});
tinymce.PluginManager.add('nexforms', tinymce.plugins.nexforms);
})();