/**
 * Handle form submission and API display
 */
( function( $, _, undefined ) {

	var container = $( document.getElementById( 'tests-list' ) ).parent(),
	    request = $.getJSON( API_URL + '/tests/' );

	request.done(function( data, status ){
		if ( 'success' !== status || ! data.success ) {
			return;
		}

		var container = $( document.getElementById( 'tests-list' ) );

		// At some point in the future, the tests could be objects with labels, descriptions, etc.
		_.each( data.data, function( test ){
			var label = $( '<label>' ),
				text = test.replace( '-', ' ' );
			label.append( '<input type="checkbox" name="tests[]" value="' + test + '" checked="checked" />' );
			text = text.replace( 'css', 'CSS' ).replace( 'php', 'PHP' ).replace( 'cdn', 'CDN' );
			label.append( '<span>' + text + '</span>' );
			container.append( label );
		});
	});

	container.on( 'focus', 'input', function(){
		$( this ).closest( 'label' ).addClass( 'focus' );
	});
	container.on( 'blur', 'input', function(){
		container.find( '.focus' ).removeClass( 'focus' );
	});

	container.on( 'click', '.check-all', function( event ){
		event.preventDefault();
		container.find( 'input' ).prop( 'checked', true );
	});
	container.on( 'click', '.check-none', function( event ){
		event.preventDefault();
		container.find( 'input' ).prop( 'checked', false );
	});

})( jQuery, _ );
