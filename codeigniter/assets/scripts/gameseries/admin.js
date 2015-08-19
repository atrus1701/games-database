
jQuery(document).ready(function($) {
	
	// Thumbnail
	$( '#gameseries-thumbnail' ).ImageSelector( { folder:base_url+'/assets/images/gameseries/thumbnail', height:64, width:64 } );
	
	// Artwork
	$( '#gameseries-artwork' ).ImageSelector( { folder:base_url+'/assets/images/gameseries/artwork', height:256, width:256 } );

	// Tags
	$( '#gameseries-tags' ).TagSelector();
	
});

