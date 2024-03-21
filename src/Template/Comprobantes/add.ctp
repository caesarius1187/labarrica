<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comprobante $comprobante
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Comprobantes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ventas'), ['controller' => 'Ventas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Venta'), ['controller' => 'Ventas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="comprobantes form large-9 medium-8 columns content">
    <?= $this->Form->create($comprobante) ?>
    <fieldset>
        <legend><?= __('Add Comprobante') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('codigo');
            echo $this->Form->control('tipo');
            echo $this->Form->control('tipodebitoasociado');
            echo $this->Form->control('tipocreditoasociado');
            echo $this->Form->control('abreviacion');
            echo $this->Form->control('abreviacion2');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
