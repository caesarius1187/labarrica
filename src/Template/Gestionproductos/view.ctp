<div class="gestionproductos view">
<h2><?php echo __('Gestionproducto'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($gestionproducto['Gestionproducto']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cliente'); ?></dt>
		<dd>
			<?php echo $this->Html->link($gestionproducto['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $gestionproducto['Cliente']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($gestionproducto['Gestionproducto']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Precio'); ?></dt>
		<dd>
			<?php echo h($gestionproducto['Gestionproducto']['precio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Stockminimo'); ?></dt>
		<dd>
			<?php echo h($gestionproducto['Gestionproducto']['stockminimo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Stockactual'); ?></dt>
		<dd>
			<?php echo h($gestionproducto['Gestionproducto']['stockactual']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Unidadmedida'); ?></dt>
		<dd>
			<?php echo h($gestionproducto['Gestionproducto']['unidadmedida']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Gestionproducto'), array('action' => 'edit', $gestionproducto['Gestionproducto']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Gestionproducto'), array('action' => 'delete', $gestionproducto['Gestionproducto']['id']), array(), __('Are you sure you want to delete # %s?', $gestionproducto['Gestionproducto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestionproductos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionproducto'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
	</ul>
</div>
