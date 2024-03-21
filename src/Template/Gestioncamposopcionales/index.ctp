<div class="gestioncamposopcionales index">
	<h2><?php echo __('Gestioncamposopcionales'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('idafip'); ?></th>
			<th><?php echo $this->Paginator->sort('valor'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($gestioncamposopcionales as $gestioncamposopcionale): ?>
	<tr>
		<td><?php echo h($gestioncamposopcionale['Gestioncamposopcionale']['id']); ?>&nbsp;</td>
		<td><?php echo h($gestioncamposopcionale['Gestioncamposopcionale']['idafip']); ?>&nbsp;</td>
		<td><?php echo h($gestioncamposopcionale['Gestioncamposopcionale']['valor']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $gestioncamposopcionale['Gestioncamposopcionale']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $gestioncamposopcionale['Gestioncamposopcionale']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $gestioncamposopcionale['Gestioncamposopcionale']['id']), array(), __('Are you sure you want to delete # %s?', $gestioncamposopcionale['Gestioncamposopcionale']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Gestioncamposopcionale'), array('action' => 'add')); ?></li>
	</ul>
</div>
