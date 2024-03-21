<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto $producto
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Productos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Rubros'), ['controller' => 'Rubros', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rubro'), ['controller' => 'Rubros', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Detallecompras'), ['controller' => 'Detallecompras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Detallecompra'), ['controller' => 'Detallecompras', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Detalleventas'), ['controller' => 'Detalleventas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Detalleventa'), ['controller' => 'Detalleventas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="productos form large-9 medium-8 columns content">
    <?= $this->Form->create($producto) ?>
    <fieldset>
        <legend><?= __('Add Producto') ?></legend>
        <?php
            echo $this->Form->control('rubro_id', ['options' => $rubros]);
            echo $this->Form->control('nombre');
            echo $this->Form->control('precio');
            echo $this->Form->control('costo');
            echo $this->Form->control('ganancia');
            echo $this->Form->control('gananciapack');
            echo $this->Form->control('preciopack');
            echo $this->Form->control('codigo');
            echo $this->Form->control('codigopack');
            echo $this->Form->control('cantpack');
            echo $this->Form->control('stockminimo');
            echo $this->Form->control('stock');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
