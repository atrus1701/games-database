/**
 * 
 * @author Crystal Barton (atrus1701)
 */

( function( $ ) {
			
	$.fn.TagSelector = function() {

		// keeps track of how many tags have been created.
		var counter = 0;


		//
		//
		//
		function add_tag( id, value, action, selections_wrapper )
		{
			// check if already exists
			var entries = $(selections_wrapper).children('div');
			
			var found = false;
			for( var i = 0; i < entries.length; i++ )
			{
				var entry = entries[i];
				if( $(entry).children( 'input[name$="[name]"]' ).attr( 'value' ) === value )
				{
					// found tag
					if( $(entry).children( 'input[name$="[action]"]' ).attr( 'value' ) === 'delete' )
					{
						$(entry).remove();
						found = false;
						action = 'update';
					}
					else
					{
						found = true;
						alert( 'This tag already exists.' );
					}
					
					i = entries.length;
				}
			}
			
			if( found ) return;
			
			// add if not with input hidden tags
			var html = '';
			html += '<input type="hidden" name="tag['+counter+'][action]" value="'+action+'" />';
			html += '<input type="hidden" name="tag['+counter+'][id]" value="'+id+'" />';
			html += '<input type="hidden" name="tag['+counter+'][name]" value="'+value+'" />';
			html += '<span>'+value+'</span>';
			
			var button = $('<button />', { text: 'remove' } )
				.click( function() {
					remove_tag( $(this).parent() );
					return false;
				});
			
			$('<div />', { class: 'item' })
				.html( html )
				.append( button )
				.appendTo( selections_wrapper );
				
			counter++;
		}
		
		
		//
		//
		//
		function remove_tag( item_wrapper )
		{
			if( $(item_wrapper).find( 'input[name$="[action]"]' ).attr( 'value' ) === 'add' )
			{
				$(item_wrapper).remove();
			}
			else
			{
				$(item_wrapper)
					.find( 'input[name$="[action]"]' )
					.attr( 'value', 'delete' );
				$(item_wrapper).hide();
			}
		}
		
		
		//
		//
		//
		function setup_tag_selector( container )
		{
			// give the container its own custom class name.
			$(container)
				.addClass('jquery-tag-selector');
					
			// get the db entries and then remove them from the container.
			var db_entries = $( container ).children( 'span[name="db"]' ).children();
			 $( container ).children( 'span[name="db"]' ).remove();

			// create wrapper for two sections of the plugin.
			var entry_wrapper = $( '<div />', { class: 'entry' } );
			var selections_wrapper = $( '<div />', { class: 'selections' } );

			// create textbox and button and append into entry wrapper.
			var textbox = $('<input />', { type: 'textbox', value: '' } );
			var button = $('<button />', { text: 'add' } )
				.click( function() {
					add_tag( '-1', $(textbox).attr('value'), 'add', selections_wrapper );
					return false;
				});			
			$(entry_wrapper)
				.append( textbox )
				.append( button );
			
			// add the wrappers to the container.
			$(container)
				.append( entry_wrapper )
				.append( selections_wrapper );
			
			// add the db entries.
			for( var i = 0; i < db_entries.length; i++ )
			{
				var entry = db_entries[i];
				var id = $(entry).attr('tag-id');
				var name = $(entry).attr('tag-name');
				var action = $(entry).attr('tag-action');
				
				add_tag( id, name, action, selections_wrapper );
			}
		}
		
		
		//
		// 
		//
		return this.each( function() { setup_tag_selector(this); } );
	}
	
})( jQuery )
