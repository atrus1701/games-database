
jQuery(document).ready(function($) {
	
	// Artwork
	$( '#company-artwork' ).ImageSelector( { folder:base_url+'/assets/images/company/artwork', height:256, width:256 } );

	// Tags
	$( '#company-tags' ).TagSelector();
	
});

