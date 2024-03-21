<div class="gestiontributos view">
<h2><?php echo __('Gestiontributo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($gestiontributo['Gestiontributo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gestionventa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($gestiontributo['Gestionventa']['id'], array('controller' => 'gestionventas', 'action' => 'view', $gestiontributo['Gestionventa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idafip'); ?></dt>
		<dd>
			<?php echo h($gestiontributo['Gestiontributo']['idafip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Desc'); ?></dt>
		<dd>
			<?php echo h($gestiontributo['Gestiontributo']['desc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Baseimponible'); ?></dt>
		<dd>
			<?php echo h($gestiontributo['Gestiontributo']['baseimponible']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Alicuota'); ?></dt>
		<dd>
			<?php echo h($gestiontributo['Gestiontributo']['alicuota']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Importe'); ?></dt>
		<dd>
			<?php echo h($gestiontributo['Gestiontributo']['importe']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Gestiontributo'), array('action' => 'edit', $gestiontributo['Gestiontributo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Gestiontributo'), array('action' => 'delete', $gestiontributo['Gestiontributo']['id']), array(), __('Are you sure you want to delete # %s?', $gestiontributo['Gestiontributo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestiontributos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestiontributo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Gestionventas'), array('controller' => 'gestionventas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gestionventa'), array('controller' => 'gestionventas', 'action' => 'add')); ?> </li>
	</ul>
</div>
