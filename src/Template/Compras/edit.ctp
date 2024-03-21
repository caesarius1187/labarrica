<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Compra $compra
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $compra->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $compra->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Compras'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Detallecompras'), ['controller' => 'Detallecompras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Detallecompra'), ['controller' => 'Detallecompras', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="compras form large-9 medium-8 columns content">
    <?= $this->Form->create($compra) ?>
    <fieldset>
        <legend><?= __('Edit Compra') ?></legend>
        <?php
            echo $this->Form->control('fecha');
            echo $this->Form->control('neto');
            echo $this->Form->control('iva');
            echo $this->Form->control('total');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
