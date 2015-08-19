
jQuery(document).ready(function($) {
	
	// Publishers
	$( '#game-publisher' ).ComboSelector( 'publisher', [ 'company-id', 'region-id' ] );
	
	// Developers
	$( '#game-developer' ).ComboSelector( 'developer', [ 'company-id' ] );
	
	// Releases
	$( '#game-release' ).ReleaseSelector( 'release', [ 'platform-id', 'region-id' ] );
	
	// Thumbnail
	$( '#game-thumbnail' ).ImageSelector( { folder:base_url+'/assets/images/game/thumbnail', height:64, width:64 } );
	
	// Artwork
	$( '#game-artwork' ).ImageSelector( { folder:base_url+'/assets/images/game/artwork', height:256, width:256 } );

	// Tags
	$('#game-tags').TagSelector();
});

