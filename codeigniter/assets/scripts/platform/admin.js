
jQuery(document).ready(function($) {
	
	// Icon
	$( '#platform-icon' ).ImageSelector( { folder:base_url+'/assets/images/platform/icon', height:16, width:16 } );
	
	// Thumbnail
	$( '#platform-thumbnail' ).ImageSelector( { folder:base_url+'/assets/images/platform/thumbnail', height:200, width:160 } );
	
	// Artwork
	$( '#platform-artwork' ).ImageSelector( { folder:base_url+'/assets/images/platform/artwork', height:256, width:256 } );

	// Tags
	$( '#platform-tags' ).TagSelector();
	
});

