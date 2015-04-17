<div class="vertical-align margin-bottom-1">
    <div class="text-left row-phone">
        <h2><?php echo __('Blocks', 'blocks'); ?></h2>
    </div>
    <div class="text-right row-phone">
        <?php
            echo (
                Html::anchor('<i class="glyphicon glyphicon-plus"></i> '.__('Create New Block', 'blocks'), 'index.php?id=blocks&action=add_block', array('title' => __('Create New Block', 'blocks'), 'class' => 'btn btn-phone btn-primary'))
            );
        ?>
    </div>
</div>

<!-- Blocks_list -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo __('Blocks', 'blocks'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($blocks_list) != 0) foreach ($blocks_list as $block) { ?>
    <tr>
        <td><?php echo $block['title']; ?> <small><i>/ <?php echo $block['name']; ?></i></small></td>
        <td>
            <div class="pull-right">            
                <div class="btn-group">
                    <?php echo Html::anchor('<i class="glyphicon glyphicon-pencil"></i> '.__('Edit', 'blocks'), 'index.php?id=blocks&action=edit_block&filename='.$block['name'], array('class' => 'btn btn-xs btn-primary')); ?>
                    <button type="button" class="btn btn-xs dropdown-toggle btn-primary" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><?php echo Html::anchor(__('View Embed Code', 'blocks'), 'javascript:;', array('title' => __('View Embed Code', 'blocks'), 'onclick' => '$.promo.blocks.showEmbedCodes("'.$block['name'].'");')); ?></li>
                    </ul>
                </div>
                <?php echo Html::anchor('<i class="glyphicon glyphicon-trash"></i> '.__('Delete', 'blocks'),
                          'index.php?id=blocks&action=delete_block&filename='.$block['name'].'&token='.Security::token(),
                           array('class' => 'btn btn-xs btn-danger', 'onclick' => "return confirmDelete('".__('Delete block: :block', 'blocks', array(':block' => $block['title']))."')"));
                ?>            
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Blocks_list -->

<div class="modal fade" id="embedCodes"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title"><?php echo __('Embed Code', 'snippets'); ?></h4>
            </div>
            <div class="modal-body">
                <b><?php echo __('Shortcode', 'snippets'); ?></b><br>
                <input type="text" id="shortcode" class="form-control" onclick="this.select();">
                <br>
                <b><?php echo __('PHP Code', 'snippets'); ?></b><br>
                <input type="text" id="phpcode" class="form-control" onclick="this.select();">
            </div>
        </div>
    </div>
</div>