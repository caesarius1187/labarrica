<div class="gestionventas form">
<?php echo $this->Form->create('Gestionventa'); ?>
	<fieldset>
		<legend><?php echo __('Edit Gestionventa'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('cliente_id');
		echo $this->Form->input('puntosdeventa_id');
		echo $this->Form->input('comprobante');
		echo $this->Form->input('fecha');
		echo $this->Form->input('concepto');
		echo $this->Form->input('servdesde');
		echo $this->Form->input('servhasta');
		echo $this->Form->input('vtopago');
		echo $this->Form->input('condicioniva');
		echo $this->Form->input('tipodocumento');
		echo $this->Form->input('documento');
		echo $this->Form->input('nombre');
		echo $this->Form->input('moneda');
		echo $this->Form->input('importeneto');
		echo $this->Form->input('importeiva');
		echo $this->Form->input('importetributos');
		echo $this->Form->input('importeivaexento');
		echo $this->Form->input('importenetogravado');
		echo $this->Form->input('importetotal');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Gestionventa.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Gestionventa.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Puntosdeventas'), array('controller' => 'puntosdeventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Puntosdeventa'), array('controller' => 'puntosdeventas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestionalicuotas'), array('controller' => 'gestionalicuotas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionalicuota'), array('controller' => 'gestionalicuotas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestiontributos'), array('controller' => 'gestiontributos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestiontributo'), array('controller' => 'gestiontributos', 'action' => 'add')); ?> </li>
	</ul>
</div>
