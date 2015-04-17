<div class="vertical-align margin-bottom-1">
    <div class="text-left row-phone">
        <h2><?php echo __('Snippets', 'snippets'); ?></h2>
    </div>
    <div class="text-right row-phone">
        <?php
            echo (
                Html::anchor('<i class="glyphicon glyphicon-plus"></i> '.__('Create New Snippet', 'snippets'), 'index.php?id=snippets&action=add_snippet', array('title' => __('Create New Snippet', 'snippets'), 'class' => 'btn btn-phone btn-primary'))
            );
        ?>
    </div>
</div>

<!-- Snippets_list -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo __('Snippets', 'snippets'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($snippets_list) != 0) foreach ($snippets_list as $snippet) { ?>
    <tr>
        <td><?php echo $snippet['title']; ?> <small><i>/ <?php echo $snippet['name']; ?></i></small></td>
        <td>
            <div class="pull-right">            
                <div class="btn-group">
                    <?php echo Html::anchor('<i class="glyphicon glyphicon-pencil"></i> '.__('Edit', 'snippets'), 'index.php?id=snippets&action=edit_snippet&filename='.$snippet['name'], array('class' => 'btn btn-xs btn-primary')); ?>
                    <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><?php echo Html::anchor(__('View Embed Code', 'snippets'), 'javascript:;', array('title' => __('View Embed Code', 'snippets'), 'onclick' => '$.promo.snippets.showEmbedCodes("'.$snippet['name'].'");')); ?></li>
                    </ul>
                </div>   
                <?php echo Html::anchor('<i class="glyphicon glyphicon-trash"></i> '.__('Delete', 'snippets'),
                    'index.php?id=snippets&action=delete_snippet&filename='.$snippet['name'].'&token='.Security::token(),
                    array('class' => 'btn btn-xs btn-danger', 'onclick' => "return confirmDelete('".__('Delete snippet: :snippet', 'snippets', array(':snippet' => $snippet['title']))."')"));
                ?>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Snippets_list -->

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