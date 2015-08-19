/**
 * 
 * @author Crystal Barton (atrus1701)
 */

( function( $ ) {
			
	$.fn.ComboSelector = function( table, unique ) {

		//
		// 
		//
		if( !table ) return;
		if( !unique || !$.isArray(unique) ) return;
		var options = {
			table: table,
			unique: unique
		};

		
		var counter = 0;

		//
		//
		//
		function get_values( inputs )
		{
			var values = {};
			for( var i = 0; i < inputs.length; i++ )
			{
				var input = inputs[i];
				switch(input.nodeName)
				{
					case('SELECT'):
						values[$(input).attr('input-id')] = { 
							id: input.options[input.selectedIndex].value,
							name: input.options[input.selectedIndex].text
						};
						break;
						
					case('INPUT'):
						values[$(input).attr('input-id')] = {
							id: input.value,
							name: input.value
						};
						break;
					
					default:
						break;
				}
			}
			
			return values;
		}
		
		
		//
		//
		//
		function get_name( id )
		{
			return options.table+'['+counter+']['+id+']';
		}
		
		
		function find_selection( values, selections_wrapper )
		{
			if( options.unique )
			{
				var selections = $( selections_wrapper ).children();

				for( var s = 0; s < selections.length; s++ )
				{
					var selection = selections[s];
					var num_options_found = 0;
					
					for( var u = 0; u < (options.unique).length; u++ )
					{
						var option = options.unique[u];
						if( $(selection).find( 'input[name$="['+option+']"][value="'+values[option].id+'"]' ).length > 0 )
							num_options_found++;
					}
					
					if( num_options_found == options.unique.length )
					{
						return selection;
					}
				}
			}
			
			return null;
		}
		
		
		//
		//
		//
		function add_selection( values, entry_wrapper, selections_wrapper, action )
		{
			// check for existing combo already.
			var selection = find_selection( values, selections_wrapper );
			if( selection !== null )
			{
				// found a match
				// current action is delete, then completely remove
				if( $(selection).find( 'input[name$="[action]"]' ).attr( 'value' ) === 'delete' )
				{
					$(selection).remove();
					action = 'update';
				}
				else
				{
					alert( 'This combination already exists.' );
					return;
				}
			}
			
			// construct hidden input tags
			// construct visible text
			var html = '<input type="hidden" name="'+get_name('action')+'" value="'+action+'" />';
			for( input_id in values )
			{
				var id = values[input_id].id;
				var name = values[input_id].name;
				html += '<input type="hidden" name="'+get_name(input_id)+'" value="'+id+'" />';
				html += '<span input-id="'+input_id+'">'+name+'</span>';
			}
			
			// create the delete button
			var button = $('<button />', { text: 'remove' } )
				.click( function() {
					remove_selection( $(this).parent() );
					return false;
				});
			
			// create item wrapper. 
			// append html and button.
			$('<div />', { class: 'item' })
				.html( html )
				.append( button )
				.appendTo( selections_wrapper );
				
			counter++;
		}
		
		
		//
		//
		//
		function remove_selection( item_wrapper, values, selections_wrapper )
		{
			if( !item_wrapper )
			{
				// create the hidden input tags
				var html = '<input type="hidden" name="'+get_name('action')+'" value="remove" />';
				for( input_id in values )
				{
					var id = values[input_id].id;
					html += '<input type="hidden" name="'+get_name(input_id)+'" value="'+id+'" />';
				}
				
				// create item wrapper and append html. 
				$('<div />', { class: 'item' })
					.html( html )
					.appendTo( selections_wrapper );
					
				counter++;
				return;
			}
			
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
		function setup_combo_selector( container )
		{
			$(container)
				.addClass('jquery-combo-selector');
					
			// get all the input that will be used for entry.
			var inputs = $(container).children( '[input-id]' );
			var db_entries = $( container ).children( 'span[name="db"]' ).children();
			 $( container ).children( 'span[name="db"]' ).remove();

			// create entry and selections wrapper.
			var entry_wrapper = $('<div />', { class: 'entry' } );
			var selections_wrapper = $('<div />', { class: 'selections' } );
			
			// create add button.
			$('<button />', { text: 'add' } )
				.click( function() {
					add_selection( get_values(inputs), entry_wrapper, selections_wrapper, 'add' );
					return false;
				})
				.appendTo( container );

			$(container)
				.wrapInner( entry_wrapper )
				.append( selections_wrapper );				

			// get existing entries from db.
			for( var e = 0; e < db_entries.length; e++ )
			{
				var entry = db_entries[e];
				var action = $(entry).attr('db-action');
				var values = {};

				for( var i = 0; i < inputs.length; i++ )
				{
					var input = inputs[i];
					var input_name = $(input).attr('input-id');
					var entry_value = $(entry).attr(input_name);
					
					switch(input.nodeName)
					{
						case('SELECT'):
							values[input_name] = { 
								id: entry_value,
								name: $(input).children( 'option[value="'+entry_value+'"]' ).text()
							};
							break;
							
						case('INPUT'):
							values[input_name] = {
								id: entry_value,
								name: entry_value
							};
							break;
						
						default:
							break;
					}
				}
				
				switch( action )
				{
					case('add'):
					case('update'):
						add_selection( values, entry_wrapper, selections_wrapper, action );
						break;
		
					case('remove'):
						remove_selection( null, values, selections_wrapper );
						break;
				}
			}
		}
		
		//
		// 
		//
		return this.each( function() { setup_combo_selector(this); } );
	}
	
})( jQuery )
