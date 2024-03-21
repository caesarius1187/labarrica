<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detalleventa $detalleventa
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Detalleventas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="detalleventas form large-9 medium-8 columns content">
    <?= $this->Form->create($detalleventa) ?>
    <fieldset>
        <legend><?= __('Add Detalleventa') ?></legend>
        <?php
            echo $this->Form->control('producto_id', ['options' => $productos, 'empty' => true]);
            echo $this->Form->control('precio');
            echo $this->Form->control('cantidad');
            echo $this->Form->control('porcentajedescuento');
            echo $this->Form->control('importedescuento');
            echo $this->Form->control('subtotal');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
