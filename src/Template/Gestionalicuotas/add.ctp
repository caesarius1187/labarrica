<div class="gestionalicuotas form">
<?php echo $this->Form->create('Gestionalicuota'); ?>
	<fieldset>
		<legend><?php echo __('Add Gestionalicuota'); ?></legend>
	<?php
		echo $this->Form->input('gestionventa_id');
		echo $this->Form->input('idafip');
		echo $this->Form->input('baseimponible');
		echo $this->Form->input('importe');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Gestionalicuotas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
