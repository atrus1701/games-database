/**
 * 
 * @author Crystal Barton (atrus1701)
 */

( function( $ ) {
			
	$.fn.Selector = function( options ) {

		//
		// 
		//
		options = $.extend( {
			db     : 'tag',
			name   : 'id',
			group  : null,
			max    : 9999
		}, options);
		
		var counter = 0;
		var container = this;

		//
		// 
		//
		function click_item( item )
		{
			switch( $(item).attr('item-selected') )
			{
				case 'yes':
					remove_item(item);
					break;
	
				default:
					add_item(item, 'add');
					break;
			}
				
			refresh_item_choices();
		}
		
		
		function find_item( group, name )
		{			
			var group_container;
			
			if( options.group != null )
				group_container = $(container).find('.item-group['+options.group+'="'+group+'"]');
			else
				group_container = $(container).find('.item-group:first-child');
			
			var item = $(group_container).find('.item-name['+options.name+'="'+name+'"]');
			return item;
		}
		
	
		function add_item( item, action )
		{
			if( !item ) return;
			
			if( (action !== 'update') && ($(container).find('.item-name[item-selected="yes"]').length >= options.max) )
			{
				alert('over max');
				$(item).find('input[type="checkbox"]').removeAttr('checked');
				return;
			}
			
			$(item).attr('item-selected','yes');
			$(item).find('input[type="checkbox"]').attr('checked','checked');
			
			if( $(item).find('input[name$="[action]"]').attr('value') === 'delete' ) action = 'update';

			$(item).find('input[type="hidden"]').remove();

			var html = '';
			if( options.group !== null )
				html += '<input type="hidden" name="'+options.db+'['+counter+']['+options.group+']" value="'+$(item).parent().attr(options.group)+'" />';
			html += '<input type="hidden" name="'+options.db+'['+counter+']['+options.name+']" value="'+$(item).attr(options.name)+'" />';
			html += '<input type="hidden" name="'+options.db+'['+counter+'][action]" value="'+action+'" />';
			
			$(item).append( html );
			
			counter++;
		}
		
		function remove_item( item, create_inputs )
		{
			if( !item ) return;

			$(item).attr('item-selected','no');
			$(item).find('input[type="checkbox"]').removeAttr('checked');

			if( create_inputs )
			{
				$(item).find('input[type="hidden"]').remove();
				var html = '';
				if( options.group !== null )
					html += '<input type="hidden" name="'+options.db+'['+counter+']['+options.group+']" value="'+$(item).parent().attr(options.group)+'" />';
				html += '<input type="hidden" name="'+options.db+'['+counter+']['+options.name+']" value="'+$(item).attr(options.name)+'" />';
				html += '<input type="hidden" name="'+options.db+'['+counter+'][action]" value="remove" />';
				$(item).append( html );
				
				counter++;
				return;
			}
			
			if( $(item).find('input[name$="[action]"]').attr('value') === 'add' )
			{
				$(item).find('input[type="hidden"]').remove();
				return;
			}

			if( $(item).find('input[name$="[action]"]').attr('value') === 'update' )
			{
				$(item).find('input[name$="[action]"]').attr('value', 'delete');
				return;
			}
		}
		
		
		
		//
		// 
		//
		function refresh_item_choices()
		{
			var value = $(container).find('input[type="textbox"]:first-child').attr('value').trim();
			var items = $(container).find('.item-name');

			for( var i = 0; i < items.length; i++ )
			{
				var item = items[i];

				if( $(item).attr('item-selected') === 'yes' )
				{
					$(item).show();
					continue;
				}
				
				if( (value === "") || ($(item).text().toLowerCase().indexOf( value.toLowerCase() ) === -1) )
					$(item).hide();
				else
					$(item).show();
			}
		}
		
		
		
		//
		// 
		//
		function setup_selector( container )
		{	
			// get the db entries and then remove them from the container.
			var db_entries = $( container ).children( 'span[name="db"]' ).children();
			$( container ).children( 'span[name="db"]' ).remove();
	
			// create the item group wrappers.
			if( options.group )
			{				
				$(container).find('*['+options.group+']')
					.addClass( 'item-group' );
			}
			else
			{
				$(container).wrapInner( '<div class="item-group" />')
			}

			// give the container a custom class and create an entry wrapper with textbox.
			$(container)
				.addClass('jquery-selector')
				.prepend( '<div class="entry"><input type="textbox" /></div>' );
			
			// when entry gets focus it is diverted to the textbox.
			$(container).find('div.entry')
				.click( function() {
					$(this).find('input[type="textbox"]').focus();
				});
			
			// whenever something new is entered, then update the choices.
			$(container).find('input')
				.keyup( function() {
					refresh_item_choices();
				}); // [container input].keyup
			
			// foreach option, add a custom class, checkbox, and click function.
			$(container).find('*['+options.name+']')
				.each( function() {

					$(this)
						.addClass( 'item-name' )
						.prepend( '<input type="checkbox" />' )
						.click( function() {
							click_item(this);
						}); // [this].click

					
					if( $(this).attr('item-selected') === 'yes' )
						add_item(this, 'update');
	
				}); // [container *[options.group]].each

			// add existing entries
			// add the db entries.
			for( var i = 0; i < db_entries.length; i++ )
			{
				var entry = db_entries[i];
				var group = null;
				if( options.group != null )
					group = $(entry).attr(options.group);
				var name = $(entry).attr(options.name);
				var action = $(entry).attr('action');
				
				switch( action )
				{
					case( 'delete' ):
						remove_item( find_item(group, name), true );
						break;
						
					case( 'update' ):
					case( 'add' ):
						add_item( find_item(group, name), action );
				}
			}
			
			refresh_item_choices();
			
		}
		
		return this.each( function() { setup_selector(this); } );
		
	}
	
})( jQuery )
