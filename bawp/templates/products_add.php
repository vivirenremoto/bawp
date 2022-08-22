<script type="text/javascript">
var BAWP_PARENT_ID = '<?=$id?>';
</script>

<div style="margin-right:15px">

<input type="hidden" id="bawp_shop_<?=$i?>" value="<?=$shop?>">

<h1 class="wp-heading-inline"><?=__('Add items', 'bawp')?>: <?=$item->name?></h1>

<?=sprintf(__('Enter a valid %s URL', 'bawp'), BAWP_WEB_URL)?>
<br><br>

1- <?=__('A specific accommodation', 'bawp')?>
<br>
<?=__('https://www.booking.com/hotel/es/barcelona-1882-barcelona1.html', 'bawp')?>
<br><br>

2- <?=__('Result list', 'bawp')?>
<br>
<?=__('https://www.booking.com/searchresults.html?aid=1610682&label=barcelona-Gd5TWXVUjLMSEJdX1ttzwQS341843104301...', 'bawp')?>

<br><br>

<input type="text" class="bawp_block" size="30" id="search" placeholder="URL <?=BAWP_WEB_URL?>">

<input type="button" class="button button-primary bawp_block" id="btn_search" value="<?=__('Search', 'bawp')?>"> 

<a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_edit&id=<?=$id?>" class="button bawp_block"><?=__('Back', 'bawp')?></a>

<br><br>

<div id="box_search"></div>

</div>

<script>
jQuery(function(){

  jQuery('#btn_search').click(function(){

    var query = jQuery('#search').val();

    if( query ){

      jQuery('#box_search').html('<img src="<?=get_site_url()?>/wp-content/plugins/bawp/static/img/loading.gif"><br><?=addslashes(__('Loading...', 'bawp'))?>');

      var data = {
        'action': 'bawp_search',
        'search': query,
      };
      jQuery.post(ajaxurl, data, function(data){
          jQuery('#box_search').html(data);
          bawp_load();

          jQuery('#table_result').DataTable({
              paging: false,
              searching: false,
              order: [[ 4, 'desc' ]]
          });

      });

    }else{
      jQuery('#box_search').html('<?=addslashes(sprintf(__('Enter a valid %s URL', 'bawp'), BAWP_WEB_URL))?>');
    }

    
  });


  jQuery('#search').keypress(function(e) {
      if(e.which == 13) {
          jQuery('#btn_search').click();
      }
  });


  

});
</script>


