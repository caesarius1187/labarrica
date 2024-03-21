<div class="gestioncamposopcionales form">
<?php echo $this->Form->create('Gestioncamposopcionale'); ?>
	<fieldset>
		<legend><?php echo __('Edit Gestioncamposopcionale'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('idafip');
		echo $this->Form->input('valor');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Gestioncamposopcionale.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Gestioncamposopcionale.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Gestioncamposopcionales'), array('action' => 'index')); ?></li>
	</ul>
</div>
