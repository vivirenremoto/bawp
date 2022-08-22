<?php if( $items ): ?>



<?php if( count($items) > 1 ): ?>
  <a href="javascript:;" class="button bawp_block" onclick="add_all_items()"><?=__('Add all items', 'bawp' )?></a>
  <br><br>
<?php endif ?>



<table class="wp-list-table widefat striped bawp_table_admin sortable-theme-light" id="table_result">
<thead>
<tr>
  <th><?=__('Photo', 'bawp' )?></th>
  <th><?=__('Name', 'bawp' )?></th>
  <th><?=__('Stars', 'bawp' )?></th>
  <th><?=__('Rating', 'bawp' )?></th>
  <th><?=__('Score', 'bawp' )?></th>
  <th><?=__('Reviews', 'bawp' )?></th>
  <th><?=__('Action', 'bawp' )?></th>
</tr>
</thead>
<tbody>

<?php $i=0; foreach( $items as $item ): extract((array)$item); $i++; 

$obj_id = isset($search) ? $i : $id;
$name = stripslashes($name);

?>
  <tr id="bawp_product_<?=$obj_id?>" data-name="<?=$name?>" data-url="<?=$url?>" data-photo="<?=$photo?>" data-stars="<?=$stars?>" data-rating="<?=$rating?>" data-score="<?=$score?>" data-reviews="<?=$reviews?>" data-description="<?=$description?>">
    


    <td style="height:40px;width:40px">
    	<img src="<?=$photo?>" style="max-width:30px;max-height:30px;">
    	&nbsp;
    </td>
    <td><a href="<?=$url?>" target="_blank"><?=$name?></a></td>
    <td nowrap="nowrap"><span class="show_mobile"><?=__('Stars', 'bawp' )?>: </span><?=$stars?></td>
    <td nowrap="nowrap"><span class="show_mobile"><?=__('Rating', 'bawp' )?>: </span><?=$rating?></td>
    <td nowrap="nowrap"><span class="show_mobile"><?=__('Score', 'bawp' )?>: </span><?=$score?></td>
    <td nowrap="nowrap"><span class="show_mobile"><?=__('Reviews', 'bawp' )?>: </span><?=$reviews?></td>
    <td nowrap="nowrap">
      
      <a href="javascript:;" class="button button-primary btn_add" data-id="<?=$i?>"><?=__('Add item', 'bawp' )?></a>
       

      

    </td>
  </tr>
<?php endforeach ?>
</tbody>
</table>


<?php else: ?>
	<?=__('No results found', 'bawp' )?>
<?php endif ?>