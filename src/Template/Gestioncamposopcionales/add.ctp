<div class="gestioncamposopcionales form">
<?php echo $this->Form->create('Gestioncamposopcionale'); ?>
	<fieldset>
		<legend><?php echo __('Add Gestioncamposopcionale'); ?></legend>
	<?php
		echo $this->Form->input('idafip');
		echo $this->Form->input('valor');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Gestioncamposopcionales'), array('action' => 'index')); ?></li>
	</ul>
</div>
