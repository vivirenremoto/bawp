<script type="text/javascript">
var BAWP_LANG_CUSTOM_TEXT = '<?=__('Custom text','bawp')?>';
var BAWP_LANG_CUSTOM_BUTTON_TEXT = '<?=__('Custom button text','bawp')?>';
var BAWP_LANG_STARS = '<?=__('Custom stars','bawp')?>';
var BAWP_LANG_YES = '<?=__('Yes','bawp')?>';
var BAWP_LANG_NO = '<?=__('No','bawp')?>';
var BAWP_PARENT_ID = '<?=$id?>';
var BAWP_TABLE_ROWS = <?php echo stripslashes($item->rows); ?>;
var BAWP_ITEMS = '<?=count($items)?>';
var BAWP_PRODUCTS = [];

<?php foreach( $items as $itm ): ?>
  BAWP_PRODUCTS.push( <?=$itm->rows?> );
<?php endforeach ?>



jQuery(function(){
  bawp_rewrite_rows();
  jQuery('input.featured_color').drawrpalette();
  jQuery('input.featured_color').css('display','inherit !important');
  jQuery('button.featured_color').css('position','relative');
  jQuery('button.featured_color').css('top','11px');
  jQuery('button.featured_color').css('width','27px');
  jQuery('button.featured_color').css('height','27px');
});
</script>

<div id="alert_saved" style="display:none;font-size:16px !important;background:#46b450; color:#fff; padding:15px 25px;margin:15px 0 15px 0; position:fixed; right:20px; bottom:20px;"><?=__('Changes saved successfully', 'bawp' )?></div>

<div style="margin-right:15px">



<div class="notice notice-warning" style="padding:11px 15px;margin-left:0;"><?=__('We recommend saving the changes every time you make a change in the table', 'bawp')?></div>


<h1 class="wp-heading-inline"><?=__('Edit table', 'bawp' )?></h1>

<?=__('Name', 'bawp' )?>:<br>
<input type="text" class="bawp_block" id="table_name" value="<?=$item->name?>" size="30"> 
<button class="button button-primary bawp_block btn_save" onclick="bawp_update_table()"><?=__('Save changes', 'bawp' )?></button> 
<a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_tables" class="button bawp_block"><?=__('Back to tables', 'bawp' )?></a>

<br><br>






<div style="border:1px #ccc solid;padding:15px;overflow-x:scroll;">

<b><?=__('Add rows', 'bawp' )?></b>

<br><br>

<button class="button bawp_block" onclick="bawp_add_row_button()"><?=__('Add new row', 'bawp' )?></button> 


<button id="sort_rows_on" class="button bawp_block" onclick="toggle_move_rows()"><?=__('Change item order', 'bawp' )?></button>
<button id="sort_rows_off" class="button bawp_block btn_save" onclick="toggle_move_rows()" style="display:none"><?=__('Save item order', 'bawp' )?></button>



<br><br>

<table id="table_rows_default" style="display:none">
<tbody>
<tr>
<td class="td_move" style="display:none">
  <img src="<?=get_site_url()?>/wp-content/plugins/bawp/static/img/move.png" width="20" height="20" style="cursor:move">
</td>
<td>
  <input type="text" placeholder="<?=__('Write label or leave it empty', 'bawp' )?>" size="30" onkeyup="bawp_change_label( this )">
</td>
<td>
  <select>
    <option value=""><?=__('Type...', 'bawp' )?></option>
    <option value="name"><?=__('Name', 'bawp' )?></option>
    <option value="photo"><?=__('Photo', 'bawp' )?></option>
    <option value="stars"><?=__('Stars', 'bawp' )?></option>
    <option value="rating"><?=__('Rating', 'bawp' )?></option>
    <option value="score"><?=__('Score', 'bawp' )?></option>
    <option value="reviews"><?=__('Reviews', 'bawp' )?></option>
    <option value="description"><?=__('Description', 'bawp' )?></option>
    <option value="button_book"><?=__('Book now button', 'bawp' )?></option>
    <option value="button_price"><?=__('Show price button', 'bawp' )?></option>
    <option value="button_reviews"><?=__('Show reviews button', 'bawp' )?></option>
    <option value="button_custom"><?=__('Custom button', 'bawp' )?></option>
    <option value="check"><?=__('Yes/No', 'bawp' )?></option>
    <option value="text"><?=__('Custom text', 'bawp' )?></option>
  </select>
</td>
<td>
  <button class="button" onclick="bawp_delete_table_row( this )"><?=__('Delete', 'bawp' )?></button>
</td>
</tr>
</tbody>
</table>

<table id="table_rows" class="tableOne"><tbody></tbody></table>


</div>

<br>


<a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_products_add&id=<?=$id?>" class="button button-primary bawp_block"><?=__('Add item', 'bawp' )?></a> 


<?php if( $items ): ?>


<button id="sort_products_on" class="button bawp_block" onclick="toggle_move_products()"><?=__('Change item order', 'bawp' )?></button>
<button id="sort_products_off" class="button bawp_block btn_save" onclick="toggle_move_products()" style="display:none"><?=__('Save item order', 'bawp' )?></button>

<br><br>


    <table class="wp-list-table widefat cancel" id="product_list" style="border:0;background:none;border-collapse: separate;border-spacing: 0 8px;">
    <tbody>

    <?php $i=0; foreach( $items as $item ): extract((array)$item); $i++; 


    $obj_id = $i;
    $name = stripslashes($name);

    ?>


      <tr id="bawp_product_<?=$item->id?>" data-name="<?=$name?>" data-url="<?=$url?>" data-photo="<?=$photo?>" data-score="<?=$score?>" data-reviews="<?=$reviews?>" data-description="<?=$description?>" 
        style="background:#fff;border:1px #ccc solid;"
        >

        <td width="1" class="col_move" style="display:none">
          <img src="<?=get_site_url()?>/wp-content/plugins/bawp/static/img/move.png" width="20" height="20" style="cursor:move">
        </td>
        <td>

          <b><?=$name?></b>
          
          <br><br>

          <table border="0" cellspacing="1" cellpadding="5" data-id="<?=$id?>" id="table_item_<?=$obj_id?>" class="table_item tableTwo" style="background:#ccc">
          </table>

          <div class="featured_options">

            <br>

            <?=__('Featured label', 'bawp' )?> <input type="text" class="featured_label" value="<?=$featured_label?>">

            <br><br>

            <?=__('Featured color', 'bawp' )?> <input type="text" class="featured_color" value="<?=$featured_color?>">

          </div>
        </td>
        <td width="1" class="col_delete">

          
          <a href="javascript:;" class="button btn_delete bawp_block" data-id="<?=$id?>"><?=__('Delete', 'bawp' )?></a>
           

          

        </td>
      </tr>
  <?php endforeach ?>
  </tbody>
</table>

<br>
<button class="button button-primary bawp_block btn_save" onclick="bawp_update_table()"><?=__('Save changes', 'bawp' )?></button>


<?php endif ?>




<a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_delete&id=<?=$id?>" onclick="if( !confirm( BAWP_LANG_SURE ) ) return false;" class="button button-secondary delete bawp_block" style="float:right;background:#E35E5E;color:#fff"><?=__('Delete table', 'bawp' )?></a>




</div>