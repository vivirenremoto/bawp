jQuery(function(){

	if( jQuery(window).width() < 481 ){

		jQuery('.bawp_table_vertical').each(function(){
			var bawp_table = jQuery(this).parent().data('id');

			var bawp_columns = jQuery(this).parent().find('.bawp_table_content').find('tr:first td').length - 1;

			var bawp_content = jQuery(this).parent().find('.bawp_table_content').html();

			var key_hotel = 0;

			for(var i=0; i<bawp_columns; i++){


				key_hotel++;

				jQuery(this).append( bawp_content );

				var bawp_table_last = jQuery(this).find('table:last');

				jQuery(bawp_table_last).find('tr').each(function(){

					for(var k=bawp_columns; k>0; k--){

						if( k != key_hotel ){
							jQuery(this).find('td:eq('+k+')').remove();
						}
					}

				});

			}

			jQuery(this).parent().find('.bawp_table_content').remove();


		});

	}


	jQuery('.bawp_table').each(function(){
		var bawp_table = jQuery(this).find('table');
		var bawp_scroll = jQuery(this).data('scroll');
		var bawp_column_width = jQuery(this).data('column_width');

		if( jQuery(window).width() > 481 ){

			if( !bawp_column_width ) bawp_column_width = 250;

			var bawp_columns = jQuery(bawp_table).find('tr:first td').length;

			jQuery(bawp_table).css('width', (bawp_columns * bawp_column_width) + 'px' );

			jQuery(bawp_table).find('tr').each(function(){
				jQuery(this).find('td:first').css('width', (bawp_column_width / 2) + 'px');
			});
		}

	});


	if( jQuery('#wpadminbar').length == 1 ){
		jQuery('.bawp_table').each(function(){
			var table_id = jQuery(this).data('id');
			jQuery(this).append('<div><a href="' + BAWP_DOMAIN + '/wp-admin/admin.php?page=bawp_edit&id=' + table_id + '" target="_blank">' + BAWP_LANG_EDIT_TABLE + '</a></div>');
		});
	}


	jQuery('.bawp_ajax').each(function(key, obj){
		jQuery.get( BAWP_PLUGIN_AJAX_URL + '?' + jQuery(this).data('atts'), function( data ) {
			jQuery('.bawp_ajax:eq(' + key + ')').html( data );
		});
	});


});