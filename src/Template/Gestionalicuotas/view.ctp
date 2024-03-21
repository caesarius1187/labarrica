<div class="gestionalicuotas view">
<h2><?php echo __('Gestionalicuota'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($gestionalicuota['Gestionalicuota']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gestionventa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($gestionalicuota['Gestionventa']['id'], array('controller' => 'gestionventas', 'action' => 'view', $gestionalicuota['Gestionventa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idafip'); ?></dt>
		<dd>
			<?php echo h($gestionalicuota['Gestionalicuota']['idafip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Baseimponible'); ?></dt>
		<dd>
			<?php echo h($gestionalicuota['Gestionalicuota']['baseimponible']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Importe'); ?></dt>
		<dd>
			<?php echo h($gestionalicuota['Gestionalicuota']['importe']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Gestionalicuota'), array('action' => 'edit', $gestionalicuota['Gestionalicuota']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Gestionalicuota'), array('action' => 'delete', $gestionalicuota['Gestionalicuota']['id']), array(), __('Are you sure you want to delete # %s?', $gestionalicuota['Gestionalicuota']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestionalicuotas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionalicuota'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
