/**
 * Handle form submission and API display
 */
( function( $, _, undefined ) {

	var handleSubmission,
	    beforeResults,
	    afterResults,
	    showResults,
	    form = $( document.forms[0] );

	handleSubmission = function( event ){
		event.preventDefault();

		// UI updates
		beforeResults();

		var data = new FormData( form );
		data.append( 'theme', $('input[type="file"]').get(0).files[0] );
		_.each( $('fieldset input:checked').get(), function( test ){ data.append( 'tests[]', test.value ); });

		var request = $.ajax({
			type: "POST",
			url: API_URL + '/validate/',
			data: data,
			processData: false,
			contentType: false,
			dataType: 'json'
		});

		request.done( showResults );
	};

	showResults = function( data, status ){
		if ( 'success' !== status ) {
			return;
		}

		if ( ! data.success ) {
			form.prepend( '<div class="error">' + data.data + '</div>' );
			afterResults();
			return;
		}

		var label = [{
			className: 'reqired',
			textName:  'Required: These issues must be fixed before uploading to WordPress.org.'
		},{
			className: 'warning',
			textName:  'Warning: These issues must be fixed…'
		},{
			className: 'recommended',
			textName:  'Recommended: These issues should be fixed before uploading to WordPress.org.'
		},{
			className: 'info',
			textName:  'Info: '
		}];

		var tmpl = _.template( $("#tmpl-result").html() ),
		    score = _.template( $("#tmpl-score").html() ),
		    list = $( '<ul />' ).addClass( 'results' );

		_.each( [0,1,2,3], function( level ){
			subset = _.where( data.data.results, { level: level } );
			if ( subset.length >= 1 ) {
				container = $( "<ul />" ).addClass( label[level].className );
				_.each( subset, function( result ) {
					container.append( tmpl( result ) );
				});
				list.append( $('<li>').text( label[level].textName ).append( container ) );
			}
		});

		$( form ).prepend( score({ passes: data.data.passes, total: data.data.total }) );
		$( form ).append( list );
	};

	beforeResults = function(){
		form.addClass( 'processing' );
		form.find( '.error' ).remove();
	}

	afterResults = function(){
		form.removeClass( 'processing' );
	};

	form.on( 'submit', handleSubmission);

	// Wait for file to be uploaded & processed
	// Display results

})( jQuery, _ );
