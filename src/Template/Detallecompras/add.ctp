<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detallecompra $detallecompra
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Detallecompras'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Compras'), ['controller' => 'Compras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Compra'), ['controller' => 'Compras', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="detallecompras form large-9 medium-8 columns content">
    <?= $this->Form->create($detallecompra) ?>
    <fieldset>
        <legend><?= __('Add Detallecompra') ?></legend>
        <?php
            echo $this->Form->control('compra_id', ['options' => $compras, 'empty' => true]);
            echo $this->Form->control('producto_id', ['options' => $productos, 'empty' => true]);
            echo $this->Form->control('cantidad');
            echo $this->Form->control('precio');
            echo $this->Form->control('porcentajeganancia');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
