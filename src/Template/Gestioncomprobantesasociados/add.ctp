<div class="gestioncomprobantesasociados form">
<?php echo $this->Form->create('Gestioncomprobantesasociado'); ?>
	<fieldset>
		<legend><?php echo __('Add Gestioncomprobantesasociado'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Gestioncomprobantesasociados'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
