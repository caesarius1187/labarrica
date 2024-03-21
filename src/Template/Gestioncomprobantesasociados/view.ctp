<div class="gestioncomprobantesasociados view">
<h2><?php echo __('Gestioncomprobantesasociado'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gestionventa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($gestioncomprobantesasociado['Gestionventa']['id'], array('controller' => 'gestionventas', 'action' => 'view', $gestioncomprobantesasociado['Gestionventa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo'); ?></dt>
		<dd>
			<?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['tipo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Puntodeventa'); ?></dt>
		<dd>
			<?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['puntodeventa']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numero'); ?></dt>
		<dd>
			<?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['numero']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cuit'); ?></dt>
		<dd>
			<?php echo h($gestioncomprobantesasociado['Gestioncomprobantesasociado']['cuit']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Gestioncomprobantesasociado'), array('action' => 'edit', $gestioncomprobantesasociado['Gestioncomprobantesasociado']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Gestioncomprobantesasociado'), array('action' => 'delete', $gestioncomprobantesasociado['Gestioncomprobantesasociado']['id']), array(), __('Are you sure you want to delete # %s?', $gestioncomprobantesasociado['Gestioncomprobantesasociado']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestioncomprobantesasociados'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestioncomprobantesasociado'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
