<script>
var BAWP_CLONE_ID;
</script>

<h1 class="wp-heading-inline">BAWP - <?=__('Tables', 'bawp' )?></h1>

<form method="post">
  <input type="text" class="bawp_block" name="name" size="40" placeholder="<?=__("Table's name", 'bawp' )?>"> 
  <input type="submit" value="<?=__('Create', 'bawp' )?>" class="button button-primary bawp_block"> 
</form>

<br>

<?php if( $items ): ?>

    <table class="wp-list-table widefat striped bawp_table_admin">
    <thead>
    <tr>
      <th>ID</th>
      <th><?=__('Name', 'bawp' )?></th>
      <th><?=__('Items', 'bawp' )?></th>
      <th><?=__('Shortcode', 'bawp' )?></th>
      <th><?=__('Action', 'bawp' )?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach( $items as $item ): extract((array)$item); ?>
      <tr>
      <td>
        <span class="show_mobile">ID: </span>
        <?=$id?>
      </td>
      <td>
          <a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_edit&id=<?=$id?>" class="table_name"><?=$name?></a>
        </td>
        <td>
          <span class="show_mobile"><?=__('Items', 'bawp')?>: </span>
          <?=$total_products?>
        </td>
        <td>
          <input type="text" class="bawp_block" size="25" value='[bawp table="<?=$id?>"]' onclick="this.select()" readonly="readonly" >
        </td>
        <td>
          <a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_edit&id=<?=$id?>" class="button button-primary"><?=__('Edit', 'bawp' )?></a> 

          <a href="#" class="button" onclick="BAWP_CLONE_ID=<?=$id?>;jQuery('#clone_table').html( jQuery(this).parent().parent().find('.table_name').html() );jQuery('#clone_modal').show();return false;"><?=__('Clone', 'bawp' )?></a>

          <a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_delete&id=<?=$id?>" class="button" onclick="if( !confirm( BAWP_LANG_SURE ) ) return false;"><?=__('Delete', 'bawp' )?></a>

        </td>
      </tr>
  <?php endforeach ?>
  </tbody>
</table>




<div id="clone_modal" style="display:none;text-align:center;position:fixed;width: 300px;height: 200px;top: 50%;margin-left: -150px;left: 50%;border:5px black solid;margin-top: -100px;background:#fff;padding:20px;z-index: 99999999;">
  
  <h3 style="margin-top:0"><?=__('Clone table', 'bawp' )?></h3>
  
  "<span id="clone_table"></span>"

  <br><br>
  
  <a href="#" class="button" onclick="document.location='<?=get_site_url()?>/wp-admin/admin.php?page=bawp_clone_structure&id=' + BAWP_CLONE_ID;" style="display:block"><?=__('Only structure', 'bawp' )?></a>

  <br>

  <a href="#" class="button" onclick="document.location='<?=get_site_url()?>/wp-admin/admin.php?page=bawp_clone&id=' + BAWP_CLONE_ID;" style="display:block"><?=__('Structure + Data', 'bawp' )?></a>

  <br>

  <a href="#" onclick="jQuery('#clone_modal').hide();return false;" class="button button-primary" style="display:block"><?=__('Cancel', 'bawp' )?></a>

</div>



<?php endif ?>

<!--<img src="https://vivirenremoto.com/plugin-bawp/pixel.png?v=<?=time()?>">-->
