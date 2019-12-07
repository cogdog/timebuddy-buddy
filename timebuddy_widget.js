(function() {
    tinymce.PluginManager.add('timebuddy', function( editor, url ) {
        editor.addButton( 'timebuddy', {
            text: 'TB',
            icon: false,
			onclick: function() {
				editor.windowManager.open( {
					title: 'World Timebuddy Event Widget',
					body: [{
						type: 'textbox',
						name: 'code',
						label: 'Paste Code'
					}],
					onsubmit: function( e ) {
					
						if ( e.data.code.indexOf('class="wtb-ew-v1"') !== -1) {
								pstart = e.data.code.indexOf('.js?') + 4;
								pend = e.data.code.indexOf('script><i>') - 4;								
								editor.insertContent( '[timebuddy params="' + e.data.code.substring(pstart, pend) + '"]');
						} else {
						
							editor.windowManager.alert('Sorry, that does not seem to be a valid Timebuddy Event Widget code. Copy the embed code generated at https://www.worldtimebuddy.com/event-widgets');
        					return false;
		
						}
					
					
					}
				});
			}            
            
        });
    });
})();
 
