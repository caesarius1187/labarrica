<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Compra $compra
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Compra'), ['action' => 'edit', $compra->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Compra'), ['action' => 'delete', $compra->id], ['confirm' => __('Are you sure you want to delete # {0}?', $compra->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Compras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Compra'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Detallecompras'), ['controller' => 'Detallecompras', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Detallecompra'), ['controller' => 'Detallecompras', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="compras view large-9 medium-8 columns content">
    <h3><?= h($compra->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($compra->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Neto') ?></th>
            <td><?= $this->Number->format($compra->neto) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iva') ?></th>
            <td><?= $this->Number->format($compra->iva) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= $this->Number->format($compra->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($compra->fecha) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Detallecompras') ?></h4>
        <?php if (!empty($compra->detallecompras)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Compra Id') ?></th>
                <th scope="col"><?= __('Producto Id') ?></th>
                <th scope="col"><?= __('Cantidad') ?></th>
                <th scope="col"><?= __('Precio') ?></th>
                <th scope="col"><?= __('Porcentajeganancia') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($compra->detallecompras as $detallecompras): ?>
            <tr>
                <td><?= h($detallecompras->id) ?></td>
                <td><?= h($detallecompras->compra_id) ?></td>
                <td><?= h($detallecompras->producto_id) ?></td>
                <td><?= h($detallecompras->cantidad) ?></td>
                <td><?= h($detallecompras->precio) ?></td>
                <td><?= h($detallecompras->porcentajeganancia) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Detallecompras', 'action' => 'view', $detallecompras->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Detallecompras', 'action' => 'edit', $detallecompras->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Detallecompras', 'action' => 'delete', $detallecompras->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detallecompras->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
