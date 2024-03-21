<div class="gestiontributos form">
<?php echo $this->Form->create('Gestiontributo'); ?>
	<fieldset>
		<legend><?php echo __('Edit Gestiontributo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('gestionventa_id');
		echo $this->Form->input('idafip');
		echo $this->Form->input('desc');
		echo $this->Form->input('baseimponible');
		echo $this->Form->input('alicuota');
		echo $this->Form->input('importe');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Gestiontributo.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Gestiontributo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Gestiontributos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
