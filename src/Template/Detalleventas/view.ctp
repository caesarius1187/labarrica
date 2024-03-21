<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detalleventa $detalleventa
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Detalleventa'), ['action' => 'edit', $detalleventa->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Detalleventa'), ['action' => 'delete', $detalleventa->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detalleventa->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Detalleventas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Detalleventa'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="detalleventas view large-9 medium-8 columns content">
    <h3><?= h($detalleventa->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Producto') ?></th>
            <td><?= $detalleventa->has('producto') ? $this->Html->link($detalleventa->producto->id, ['controller' => 'Productos', 'action' => 'view', $detalleventa->producto->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($detalleventa->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Precio') ?></th>
            <td><?= $this->Number->format($detalleventa->precio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad') ?></th>
            <td><?= $this->Number->format($detalleventa->cantidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Porcentajedescuento') ?></th>
            <td><?= $this->Number->format($detalleventa->porcentajedescuento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Importedescuento') ?></th>
            <td><?= $this->Number->format($detalleventa->importedescuento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subtotal') ?></th>
            <td><?= $this->Number->format($detalleventa->subtotal) ?></td>
        </tr>
    </table>
</div>
