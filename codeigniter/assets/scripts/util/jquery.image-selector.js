/**
 * 
 * @author Crystal Barton (atrus1701)
 */

( function( $ ) {
			
	$.fn.ImageSelector = function( options ) {

		//
		// 
		//
		options = $.extend( {
			folder : '.',
			height : null,
			width  : null,
			type : 'image'
		}, options);

		//
		// 
		//
		function change_item( combobox, image )
		{
			var src = options.folder+'/'+combobox.options[combobox.selectedIndex].value;
			if( options.type == 'folder' )
				src += '/folder.jpg';
			$(image).attr( 'src', src );
		}
		
		
		//
		// 
		//
		function setup_image_selector( combobox )
		{
			var height = $(combobox).attr('image-height');
			var width = $(combobox).attr('image-width');
			if( height !== undefined ) options.height = height;
			if( width !== undefined ) options.width = width;

			$(combobox).wrap( '<div class="jquery-image-selector"></div>' );				
			var wrapper = $(combobox).parent();

			var image = $('<img />').appendTo( $(wrapper) );
			
			if( options.width !== null )
				$(image).attr('width', options.width);
			if( options.height !== null )
				$(image).attr('height', options.height);
			
			$(combobox)
				.change( function() {
					change_item( this, image );
				});
			
			if( (combobox.selectedIndex == -1) && (combobox.options.length > 0) )
				combobox.selectedIndex = 0;
			
			if( combobox.selectedIndex > -1 )
				change_item( combobox, image );
		}
		
		//
		// 
		//
		return this.each( function() { setup_image_selector(this); } );
	}
	
})( jQuery )
