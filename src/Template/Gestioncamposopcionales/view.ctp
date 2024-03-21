<div class="gestioncamposopcionales view">
<h2><?php echo __('Gestioncamposopcionale'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($gestioncamposopcionale['Gestioncamposopcionale']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idafip'); ?></dt>
		<dd>
			<?php echo h($gestioncamposopcionale['Gestioncamposopcionale']['idafip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valor'); ?></dt>
		<dd>
			<?php echo h($gestioncamposopcionale['Gestioncamposopcionale']['valor']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Gestioncamposopcionale'), array('action' => 'edit', $gestioncamposopcionale['Gestioncamposopcionale']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Gestioncamposopcionale'), array('action' => 'delete', $gestioncamposopcionale['Gestioncamposopcionale']['id']), array(), __('Are you sure you want to delete # %s?', $gestioncamposopcionale['Gestioncamposopcionale']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestioncamposopcionales'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestioncamposopcionale'), array('action' => 'add')); ?> </li>
	</ul>
</div>
