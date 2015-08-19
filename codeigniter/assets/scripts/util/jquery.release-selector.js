/**
 * 
 * @author Crystal Barton (atrus1701)
 */

( function( $ ) {
			
	$.fn.ReleaseSelector = function( table, unique ) {

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
		
		
		function create_tags_from_values( values, inputs )
		{
			var tags = [];

			for( var i = 0; i < inputs.length; i++ )
			{
				var input = inputs[i];
				var input_id = $(input).attr('input-id');
				var value = values[input_id];
				var name = get_name(input_id);
				
				if( (options.unique).indexOf(input_id) !== -1 )
				{
					// in unique, make a hidden element
					tags.push( $('<input />').attr('type','hidden').attr('name',name).attr('value',value.id) );
					tags.push( $('<span />').attr('input-id', input_id).html(value.name) );
				}
				else
				{
					// not in unique, make a combobox/textbox clone
					var tag = $(input).clone();
					$(tag).attr('name', name);

					switch(input.nodeName)
					{
						case('SELECT'):
							$(tag).find('option[selected="selected"]').removeAttr('selected');
							$(tag).find('option[value="'+value.id+'"]').attr('selected','selected');
							break;
							
						case('INPUT'):
							$(tag).attr('value', value.id);
							break;
						
						default:
							break;
					}

					tags.push(tag);
				}
			}
			return tags;
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
						var tag = $(selection).find( '[name$="['+option+']"]' );
						
						if( $(tag).val() == values[option].id )
						{
							num_options_found++;
						}
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
		function add_selection( values, inputs, entry_wrapper, selections_wrapper, action )
		{
			// check for existing combo already.
			var selection = find_selection( values, selections_wrapper );
			if( selection !== null )
			{
				// found a match
				// current action is delete, then completely remove
				if( $(selection).find( '[name$="[action]"]' ).attr( 'value' ) === 'delete' )
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
			var tags = create_tags_from_values( values, inputs );
			var html = '<input type="hidden" name="'+get_name('action')+'" value="'+action+'" />';
			for( var i = 0; i < tags.length; i++ )
			{
				var tag = tags[i];
				html += $(tag)[0].outerHTML;
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
		function remove_selection( item_wrapper, values, inputs, selections_wrapper )
		{
			if( !item_wrapper )
			{
				// create the hidden input tags
				var tags = create_tags_from_values( values, inputs );
				var html = '<input type="hidden" name="'+get_name('action')+'" value="remove" />';
				for( var i = 0; i < tags.length; i++ )
				{
					var tag = tags[i];
					html += $(tag)[0].outerHTML;
				}
				
				// create item wrapper and append html. 
				$('<div />', { class: 'item' })
					.html( html )
					.appendTo( selections_wrapper )
					.hide();
					
				counter++;
				return;
			}
			
			if( $(item_wrapper).find( '[name$="[action]"]' ).attr( 'value' ) === 'add' )
			{
				$(item_wrapper).remove();
			}
			else
			{
				$(item_wrapper)
					.find( '[name$="[action]"]' )
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
					add_selection( get_values(inputs), inputs, entry_wrapper, selections_wrapper, 'add' );
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
						add_selection( values, inputs, entry_wrapper, selections_wrapper, action );
						break;
		
					case('remove'):
						remove_selection( null, values, inputs, selections_wrapper );
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
