

jQuery(document).ready(function($) {

	// Date
	$( '#news-date' ).datepicker();
	
	// News Tags
	$( '#news-tag-selector' ).Selector( { db: 'newstag', name: 'table-id', group: 'table' } );
	
});

