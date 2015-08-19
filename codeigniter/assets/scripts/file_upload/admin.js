

jQuery(document).ready(function($) {

	// change upload folder
	$( '#upload-folder' ).change( function() {
		
		if( this.selectedIndex === 0 )
		{
			$( '#gallery-folder' ).removeAttr('disabled');
		}
		else
		{
			$( '#gallery-folder' ).attr('disabled','disabled');
		}
		
	} );
	
	$( '#files' ).change( function() {
	
		var files = '';
		for( var i = 0; i < (this.files).length; i++ )
		{
			files += this.files[i].name + '<br/>';
        }
        
        $( '#file-list' ).html( files );
        
	} );
	
});

