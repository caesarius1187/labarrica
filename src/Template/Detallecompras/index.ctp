<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detallecompra[]|\Cake\Collection\CollectionInterface $detallecompras
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Detallecompra'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Compras'), ['controller' => 'Compras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Compra'), ['controller' => 'Compras', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="detallecompras index large-9 medium-8 columns content">
    <h3><?= __('Detallecompras') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('compra_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('producto_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cantidad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('precio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('porcentajeganancia') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detallecompras as $detallecompra): ?>
            <tr>
                <td><?= $this->Number->format($detallecompra->id) ?></td>
                <td><?= $detallecompra->has('compra') ? $this->Html->link($detallecompra->compra->id, ['controller' => 'Compras', 'action' => 'view', $detallecompra->compra->id]) : '' ?></td>
                <td><?= $detallecompra->has('producto') ? $this->Html->link($detallecompra->producto->id, ['controller' => 'Productos', 'action' => 'view', $detallecompra->producto->id]) : '' ?></td>
                <td><?= $this->Number->format($detallecompra->cantidad) ?></td>
                <td><?= $this->Number->format($detallecompra->precio) ?></td>
                <td><?= $this->Number->format($detallecompra->porcentajeganancia) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $detallecompra->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $detallecompra->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $detallecompra->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detallecompra->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
