<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puntodeventa $puntodeventa
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Puntodeventas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ventas'), ['controller' => 'Ventas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Venta'), ['controller' => 'Ventas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="puntodeventas form large-9 medium-8 columns content">
    <?= $this->Form->create($puntodeventa) ?>
    <fieldset>
        <legend><?= __('Add Puntodeventa') ?></legend>
        <?php
            echo $this->Form->control('numero');
            echo $this->Form->control('nombre');
            echo $this->Form->control('descripcion');
            echo $this->Form->control('facturacionhabilitada');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
