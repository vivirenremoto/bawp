
jQuery(function(){
	bawp_load();

	

});


function bawp_load(){

	jQuery('a.btn_delete').click(function(index) {

		if( !confirm( BAWP_LANG_SURE ) ) return;

		var id = jQuery(this).data('id');

		jQuery('#bawp_product_' + id).remove();

		if( jQuery("#product_list > tbody > tr").length == 0 ) jQuery('#sort_products_on').hide();



		var data = {
			'action': 'bawp_item_delete',
			'id': id,
		};
		jQuery.post(ajaxurl, data);

		return;

	});


	jQuery('a.btn_add').click(function(index) {

		var id = jQuery(this).data('id');
		

		var bawp_product = jQuery('#bawp_product_'+id);
		jQuery('#bawp_product_'+id).remove();







		var data = {
			'action': 'bawp_item_add',
			'parent_id': BAWP_PARENT_ID,
			'name': jQuery(bawp_product).data('name'),
			'url': jQuery(bawp_product).data('url'),
			'photo': jQuery(bawp_product).data('photo'),
			'stars': jQuery(bawp_product).data('stars'),
			'rating': jQuery(bawp_product).data('rating'),
			'score': jQuery(bawp_product).data('score'),
			'reviews': jQuery(bawp_product).data('reviews'),
			'description': jQuery(bawp_product).data('description'),
		};
		jQuery.post(ajaxurl, data);



		return;

	});



}

function bawp_add_row(title, type){
	jQuery('#table_rows tbody').append( jQuery('#table_rows_default tbody').html() );
	jQuery('#table_rows input:last').val( title );
	jQuery('#table_rows select:last').val( type );

}

function bawp_add_row_button(title, type){

	bawp_add_row(title, type);

	bawp_save_rows();
	
}

function bawp_save_rows(){



	var table_rows = jQuery('#table_rows tr');
	var rows = [];
	if( table_rows.size() ){
		jQuery(table_rows).each(function(){
			var item = jQuery(this);
			var title = jQuery(item).find('input').val();
			var type = jQuery(item).find('select').val();
			rows.push( {'title': title, 'type': type} );
		});
	}

	var data = {
		'action': 'bawp_table_save',
		'name': jQuery('#table_name').val(),
		'id': BAWP_PARENT_ID,
		'rows': JSON.stringify(rows),
	};
	jQuery.post(ajaxurl, data, function(){
		document.location.reload();
	});	


}


function bawp_delete_table_row(obj){

	if( !confirm( BAWP_LANG_SURE ) ) return;

	var rowIndex = jQuery(obj).parent().parent().index();


	jQuery(obj).parent().parent().remove();


	jQuery('.table_item tr').filter(function () {
		return jQuery(this).index() === rowIndex;
	}).remove();



	bawp_save_rows();



}


function bawp_change_label(obj){
	var rowIndex = jQuery(obj).parent().parent().index();

	jQuery('.tableTwo tr').filter(function () {
		return jQuery(this).index() === rowIndex;
	}).find('td:first').html(  jQuery(obj).val() );
}

function bawp_update_table(){
	jQuery('.btn_save').attr('disabled','disabled');

	var table_rows = jQuery('#table_rows tr');
	var rows = [];
	if( table_rows.size() ){
		jQuery(table_rows).each(function(){
			var item = jQuery(this);
			var title = jQuery(item).find('input').val();
			var type = jQuery(item).find('select').val();
			rows.push( {'title': title, 'type': type} );
		});
	}



	var tables = jQuery('.table_item');
	var products = [];
	var sort = 1;
	if( tables.size() ){
		jQuery(tables).each(function(){
			var products_items = [];
			var item_id = jQuery(this).data('id');
			var featured_color = jQuery('#bawp_product_' + item_id).find('.featured_color').val();
			var featured_label = jQuery('#bawp_product_' + item_id).find('.featured_label').val();
			jQuery(this).find('tr').each(function(){
				var item = jQuery(this);
				var value = '';

				if( jQuery(item).find('input[type=text]').size() ){
					value = jQuery(item).find('input').val();
				}else if( jQuery(item).find('input[type=radio]').size() ){
					value = jQuery(item).find('input:checked').val();
				}else if( jQuery(item).find('select').size() ){
					value = jQuery(item).find('select').val();
				}

				products_items.push( value );

			});
			products.push({
				'rows': products_items,
				'sort': sort,
				'id': item_id,
				'featured_color': featured_color,
				'featured_label': featured_label
			});
			sort++;
		});
	}


	var data = {
		'action': 'bawp_table_save',
		'name': jQuery('#table_name').val(),
		'id': BAWP_PARENT_ID,
		'rows': JSON.stringify(rows),
		'products': JSON.stringify(products)
	};
	jQuery.post(ajaxurl, data, function(){
		jQuery('#alert_saved').show().delay(2000).fadeOut('slow');

		setTimeout(function(){
			document.location.reload();
		}, 2000);
	});

}

function bawp_rewrite_rows(){
	jQuery(BAWP_TABLE_ROWS).each(function(index){
		var item = BAWP_TABLE_ROWS[index];
		var title = item.title;
		var type = item.type;
		bawp_add_row(title, type);

	});

	for(var i=0; i < BAWP_ITEMS; i++){

		var product = BAWP_PRODUCTS[i];

		jQuery(BAWP_TABLE_ROWS).each(function(index){

			var item = BAWP_TABLE_ROWS[index];
			var title = item.title;
			var type = item.type;


			var value;

			if( product ){
				value = product[index];
			}else{
				value = '';
			}



			if( typeof value === 'undefined' ){
				value = '';
			}

			var type_html;

			if( type == 'text' ){
				type_html = '<input type="text" placeholder="' + BAWP_LANG_CUSTOM_TEXT + '" size="40" value="' + value + '">';
			}else if( type == 'stars' ){
				type_html = '<input type="text" placeholder="' + BAWP_LANG_STARS + '" size="40" value="' + value + '">';
			}else if( type == 'check' ){
				var check1;
				var check2;
				if( value == 1 || value == '' ){
					check1 = 'checked="checked"';
					check2 = ''; 
				}else{
					check1 = '';
					check2 = 'checked="checked"'; 
				}
				type_html = '<label><input name="option_'+index+'_' + (i+1) + '" type="radio" value="1" ' + check1 + '> ' + BAWP_LANG_YES + '</label> ';
				type_html += '<label><input name="option_'+index+'_' + (i+1) + '" type="radio" value="0" ' + check2 + '> ' + BAWP_LANG_NO + '</label> ';
			}else if( type == 'button_custom' ){
				type_html = '<input type="text" placeholder="' + BAWP_LANG_CUSTOM_BUTTON_TEXT + '" size="40" value="' + value + '">';
			}else{
				type_html = '-';
			}

			var html = '';
			html += '<tr>';
			html += '<td bgcolor="#fff">' + title + '</td>';
			html += '<td bgcolor="#fff">' + type_html + '</td>';
			html += '</tr>';

			jQuery('#table_item_'+(i+1)).append(html);

		});
	}




	jQuery('.tableOne tr').each(function (idx) {
	    if (idx > jQuery('.tableTwo tr').length) 
	        return;
	    
		jQuery(this).attr('data-row-id', idx);
		

		jQuery('.tableTwo').each(function(){
			var $tableTwoTr = jQuery(this).find('tr').eq(idx);
			$tableTwoTr.attr('data-row-id', idx);
		});

	});




	jQuery('#product_list tbody').sortable({
		placeholder: 'ui-state-highlight'

	});

	if( jQuery('#sort_products_on:visible') ){
		jQuery('#product_list tbody').sortable( 'disable' );
	}else{
		jQuery('#product_list tbody').sortable( 'enable' );
	}

}

function toggle_move_rows(){
	if( jQuery('#sort_rows_on:visible').size() ){
		jQuery('#sort_rows_on').hide();
		jQuery('#sort_rows_off').show();
		jQuery('.td_move').show();

		jQuery('.tableOne tbody').sortable({
			placeholder: 'ui-state-highlight',
			beforeStop: function(e, ui) {    
				var rowId = jQuery(ui.helper).attr('data-row-id');
				
				var newPosition = jQuery('.tableOne tr:not(.ui-sortable-placeholder)')
					.index(jQuery(ui.helper));
				

				jQuery('.tableTwo').each(function(){

					var $tableTwoRowToMove = jQuery(this).find("tr[data-row-id='" + rowId + "']");
					
					if (newPosition == 0) {
						$tableTwoRowToMove.insertBefore(jQuery(this).find('tr').first());
					}
					else {
						$tableTwoRowToMove.insertAfter(jQuery(this).find('tr').eq(newPosition));
					}

				});
				
			}
		});

	}else{
		jQuery('#sort_rows_on').show();
		jQuery('#sort_rows_off').hide();
		jQuery('.td_move').hide();
		bawp_update_table();

	}
}

function toggle_move_products(){
	if( jQuery('#sort_products_on:visible').size() ){
		jQuery('#sort_products_on').hide();
		jQuery('#sort_products_off').show();
		jQuery('#product_list table').hide();
		jQuery('#product_list br').hide();
		jQuery('.col_move').show();
		jQuery('.col_delete').hide();
		jQuery('.featured_options').hide();
		jQuery('#product_list tbody').sortable( 'enable' );
	}else{
		jQuery('#sort_products_on').show();
		jQuery('#sort_products_off').hide();
		jQuery('#product_list table').show();
		jQuery('#product_list br').show();
		jQuery('.col_move').hide();
		jQuery('.col_delete').show();
		jQuery('.featured_options').show();
		jQuery('#product_list tbody').sortable( 'disable' );
		bawp_update_table();
	}
}

function add_all_items(){

	jQuery('.btn_add').each(function(){
		jQuery(this).click();
	});
}