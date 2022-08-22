<h1 class="wp-heading-inline"><?=__('License', 'bawp' )?></h1>

<br>

<?php if( $license ): ?>

    <?php if( is_bool( $license ) ): ?>
        <?=__('In a test environment no license needs to be activated', 'bawp')?>
    <?php else: ?>

        <?=__('You have already activated your license', 'bawp')?>
    
        <br><br>

        <?=__('License expiration date', 'bawp')?>: <?=date('d/m/Y', strtotime( $license ) )?>

        <br><br>

        <a href="<?=get_site_url()?>/wp-admin/admin.php?page=bawp_disable_license" class="button" style="color:red"><?=__('Deactivate license', 'bawp')?></a>

    <?php endif ?>

<?php else: ?>

    1. <?=__('In the client panel add the website where you want to use the plugin:', 'bawp')?><br>
    <a href="#">https://vivirenremoto.com/clientes/</a>

    <br><br>

    2. <?=__('Enter the license code that has been assigned to your website:', 'bawp')?>

    <br>

    <input type="text" id="license" size="50">

    <br><br>

    <button type="button" onclick="bawp_check_license()" class="button"><?=__('Verify license', 'bawp')?></button>

    <br><br>

    <div id="bawp_alert_message" style="display:none;padding:11px 15px;margin-left:0;"></div>



    <script>
    function bawp_check_license(){
    var data = {
            'action': 'bawp_check_license',
            'id': '<?=BAWP_PRODUCT_ID?>',
            'domain': document.location.hostname,
            'license': jQuery('#license').val(),
        };
        jQuery.post(ajaxurl, data, function(result){
            var msg = jQuery('#bawp_alert_message');
            if( result.valid ){
                var alert_class = 'notice notice-success';

                setTimeout(function(){
                    document.location = '<?=BAWP_DEFAULT_URL?>';
                }, 5000);
            }else{
                var alert_class = 'notice notice-error'; 
            }
            jQuery(msg).html( result.message ).attr('class', alert_class).show();
        }, 'json');
    }
    </script>

<?php endif ?>