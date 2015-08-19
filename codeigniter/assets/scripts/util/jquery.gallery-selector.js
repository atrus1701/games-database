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
			container : [ 256, 256 ],
			thumbnail : [ 32, 32 ]
		}, options);

		//
		// 
		//
		function change_item( combobox, folder )
		{
			//$(image).attr( 'src', options.folder+'\\'+combobox.selectedOptions[0].value );
		}
		
		
		//
		// 
		//
		function setup_gallery_selector( combobox )
		{
			var wrapper = $('<div />', { class: 'jquery-gallery-selector' });
			$(combobox).wrap( wrapper );				

			var container = $('<div />', { class: 'gallery' })
				.css( 'height', options.container[1] )
				.css( 'width', options.container[0] )
				.appendTo( wrapper );

			$(combobox)
				.change( function() {
					change_item( this, container );
				});
			
			if( combobox.selectedOptions.length == 0 )
				combobox.selectedIndex = 0;
			
			change_item( combobox, container );
		}
		
		//
		// 
		//
		return this.each( function() { setup_gallery_selector(this); } );
	}
	
})( jQuery )
