<div class="gestioncomprobantesasociados index">
	<h2><?php echo __('Gestioncomprobantesasociados'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('gestionventa_id'); ?></th>
			<th><?php echo $this->Paginator->sort('tipo'); ?></th>
			<th><?php echo $this->Paginator->sort('puntodeventa'); ?></th>
			<th><?php echo $this->Paginator->sort('numero'); ?></th>
			<th><?php echo $this->Paginator->sort('cuit'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($gestioncomprobantesasociados as $gestioncomprobantesasociado): ?>
	<tr>
		<td><?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($gestioncomprobantesasociado['Gestionventa']['id'], array('controller' => 'gestionventas', 'action' => 'view', $gestioncomprobantesasociado['Gestionventa']['id'])); ?>
		</td>
		<td><?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['tipo']); ?>&nbsp;</td>
		<td><?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['puntodeventa']); ?>&nbsp;</td>
		<td><?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['numero']); ?>&nbsp;</td>
		<td><?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['cuit']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $gestioncomprobantesasociado['Gestioncomprobantesasociado']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $gestioncomprobantesasociado['Gestioncomprobantesasociado']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $gestioncomprobantesasociado['Gestioncomprobantesasociado']['id']), array(), __('Are you sure you want to delete # %s?', $gestioncomprobantesasociado['Gestioncomprobantesasociado']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Gestioncomprobantesasociado'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
