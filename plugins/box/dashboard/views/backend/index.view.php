<div class="well dashboard-well">
	<div class="row">
		<div class="col-xs-6">
			<a class="btn btn-link welcome-back"><?php echo __('Welcome back', 'dashboard'); ?>, <strong><?php echo Session::get('user_login'); ?></strong></a>
		</div>
		<div class="col-xs-6">
			<div class="pull-right">
				<div class="btn-group">
				  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				    <?php echo __('Create New', 'dashboard'); ?> <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
				  	<?php Dashboard::drawItems(); ?>
				  </ul>
				</div>			
				<?php echo ( Html::anchor(__('Upload File', 'dashboard'), 'index.php?id=filesmanager', array('title' => __('Upload File', 'filesmanager'), 'class' => 'btn btn-primary'))); ?>
			</div>
		</div>
	</div>
</div>

<?php /*include 'ga.view.php';*/ ?>

<div class="well dashboard-well">
	<div class="row">
		<div class="col-md-3">
			<h3><?php echo __('Content', 'pages'); ?></h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('content'); ?>
			</ul>
		</div>
		<div class="col-md-3">			
			<h3><?php echo __('Extends', 'system'); ?></h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('extends'); ?>
			</ul>
		</div>			
		<div class="col-md-3">			
			<h3><?php echo __('System', 'system'); ?></h3>
			<ul class="list-unstyled">
				<?php Navigation::draw('system'); ?>
			</ul>
		</div>
		<div class="col-md-3">			
			<h3><?php echo __('Help', 'system'); ?></h3>
			<ul class="list-unstyled">
				<li><a href="http://cms.promo360.ru/documentation" target="_blank"><?php echo __('Documentation', 'system'); ?></a></li>
				<li><a href="http://cms.promo360.ru/forum/" target="_blank"><?php echo __('Official Support Forum', 'system'); ?></a></li>
			</ul>
		</div>
	</div>
</div>
