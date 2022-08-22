<h1 class="wp-heading-inline"><?=__("Themes", 'bawp' )?></h1>


<?php if( $items ): ?>

    <!--
    <a href="https://vivirenremoto.com/bawp-themes/" target="_blank" class="button"><?=__("Get more themes", 'bawp' )?></a>

    <br><br>
    -->

    <form method="post" style="padding-right:20px">
        <table class="wp-list-table widefat striped bawp_table_admin">
        <thead>
        <tr>
        <th><?=__("Title", 'bawp' )?></th>
        <th><?=__("Version", 'bawp' )?></th>
        <th><?=__("Authors", 'bawp' )?></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach( $items as $item ): ?>
        <tr>
            <td>
                <?=$item?>
            </td>
            <td>
                <?=$info[$item]->version?>
            </td>
            <td>
                <?=$info[$item]->authors?>
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
        </table>


        
    </form>


<?php else: ?>

    <?=__("No results found", 'bawp' )?>

<?php endif ?>