(function($){


	/*
	*  acf/setup_fields
	*
	*  This event is triggered when ACF adds any new elements to the DOM.
	*
	*  @type	function
	*  @since	1.0.0
	*  @date	01/01/12
	*
	*  @param	event		e: an event object. This can be ignored
	*  @param	Element		postbox: An element which contains the new HTML
	*
	*  @return	N/A
	*/

	$(document).live('acf/setup_fields', function(e, postbox){

		$(document).on( 'change', '.acfgfs-font-select', function( i, element ) {

			var font = $(this).val();
			var field_name = $(this).data( 'field_name' );

			$.ajax({
				url: acfgfs.ajaxurl,
				type: 'post',
				dataType: 'json',
				data: {
					action: 'acfgfs_get_font_data',
					font: font,
					field_name: field_name
				},
				beforeSend: function() {
					$( '.acfgfs-font-variants ul li, .acfgfs-font-charsets ul li' ).remove();
					$( '.acfgfs-font-variants, .acfgfs-font-charsets' ).addClass( 'loading' );
					$( '.acfgfs-font-variants .label, .acfgfs-font-charsets .label' ).after( '<span class="acfgfs-loading">'+acfgfs.loading+'</span>' );
				},
				success : function( results ) {
					$( '.acfgfs-loading' ).remove();
					$( '.acfgfs-font-variants ul' ).prepend( results.variants );
					$( '.acfgfs-font-charsets ul' ).prepend( results.charsets );
				},
			})
		})

	});

})(jQuery);
