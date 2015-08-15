<form class="form-horizontal" method="post">
	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#general" data-toggle="tab"><?php echo t( 'dunamis.admin.settings.subnav.general' ) ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="general">
				<?php echo $this->renderForm( $fields ) ?>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<?php echo $form->getButton( 'submit', array( 'class' => 'btn btn-primary span2', 'value' => t( 'dunamis.form.submit' ), 'name' => 'submit' ) ) ?>
	</div>
	
	<input type="hidden" name="task" value="save" />
</form>