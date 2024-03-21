<div class="gestioncomprobantesasociados form">
<?php echo $this->Form->create('Gestioncomprobantesasociado'); ?>
	<fieldset>
		<legend><?php echo __('Edit Gestioncomprobantesasociado'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('gestionventa_id');
		echo $this->Form->input('tipo');
		echo $this->Form->input('puntodeventa');
		echo $this->Form->input('numero');
		echo $this->Form->input('cuit');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Gestioncomprobantesasociado.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Gestioncomprobantesasociado.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Gestioncomprobantesasociados'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
