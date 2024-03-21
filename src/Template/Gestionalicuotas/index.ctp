<div class="gestionalicuotas index">
	<h2><?php echo __('Gestionalicuotas'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('gestionventa_id'); ?></th>
			<th><?php echo $this->Paginator->sort('idafip'); ?></th>
			<th><?php echo $this->Paginator->sort('baseimponible'); ?></th>
			<th><?php echo $this->Paginator->sort('importe'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($gestionalicuotas as $gestionalicuota): ?>
	<tr>
		<td><?php echo h($gestionalicuota['Gestionalicuota']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($gestionalicuota['Gestionventa']['id'], array('controller' => 'gestionventas', 'action' => 'view', $gestionalicuota['Gestionventa']['id'])); ?>
		</td>
		<td><?php echo h($gestionalicuota['Gestionalicuota']['idafip']); ?>&nbsp;</td>
		<td><?php echo h($gestionalicuota['Gestionalicuota']['baseimponible']); ?>&nbsp;</td>
		<td><?php echo h($gestionalicuota['Gestionalicuota']['importe']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $gestionalicuota['Gestionalicuota']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $gestionalicuota['Gestionalicuota']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $gestionalicuota['Gestionalicuota']['id']), array(), __('Are you sure you want to delete # %s?', $gestionalicuota['Gestionalicuota']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Gestionalicuota'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
