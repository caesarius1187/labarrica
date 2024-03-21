<div class="gestionproductos index">
	<h2><?php echo __('Gestionproductos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('cliente_id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('precio'); ?></th>
			<th><?php echo $this->Paginator->sort('stockminimo'); ?></th>
			<th><?php echo $this->Paginator->sort('stockactual'); ?></th>
			<th><?php echo $this->Paginator->sort('unidadmedida'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($gestionproductos as $gestionproducto): ?>
	<tr>
		<td><?php echo h($gestionproducto['Gestionproducto']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($gestionproducto['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'view', $gestionproducto['Cliente']['id'])); ?>
		</td>
		<td><?php echo h($gestionproducto['Gestionproducto']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($gestionproducto['Gestionproducto']['precio']); ?>&nbsp;</td>
		<td><?php echo h($gestionproducto['Gestionproducto']['stockminimo']); ?>&nbsp;</td>
		<td><?php echo h($gestionproducto['Gestionproducto']['stockactual']); ?>&nbsp;</td>
		<td><?php echo h($gestionproducto['Gestionproducto']['unidadmedida']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $gestionproducto['Gestionproducto']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $gestionproducto['Gestionproducto']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $gestionproducto['Gestionproducto']['id']), array(), __('Are you sure you want to delete # %s?', $gestionproducto['Gestionproducto']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Gestionproducto'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
	</ul>
</div>
