<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detallecompra $detallecompra
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Detallecompra'), ['action' => 'edit', $detallecompra->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Detallecompra'), ['action' => 'delete', $detallecompra->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detallecompra->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Detallecompras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Detallecompra'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Compras'), ['controller' => 'Compras', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Compra'), ['controller' => 'Compras', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="detallecompras view large-9 medium-8 columns content">
    <h3><?= h($detallecompra->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Compra') ?></th>
            <td><?= $detallecompra->has('compra') ? $this->Html->link($detallecompra->compra->id, ['controller' => 'Compras', 'action' => 'view', $detallecompra->compra->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Producto') ?></th>
            <td><?= $detallecompra->has('producto') ? $this->Html->link($detallecompra->producto->id, ['controller' => 'Productos', 'action' => 'view', $detallecompra->producto->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($detallecompra->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad') ?></th>
            <td><?= $this->Number->format($detallecompra->cantidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Precio') ?></th>
            <td><?= $this->Number->format($detallecompra->precio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Porcentajeganancia') ?></th>
            <td><?= $this->Number->format($detallecompra->porcentajeganancia) ?></td>
        </tr>
    </table>
</div>
