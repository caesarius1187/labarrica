<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detalleventa[]|\Cake\Collection\CollectionInterface $detalleventas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Detalleventa'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="detalleventas index large-9 medium-8 columns content">
    <h3><?= __('Detalleventas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('producto_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('precio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cantidad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('porcentajedescuento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('importedescuento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subtotal') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalleventas as $detalleventa): ?>
            <tr>
                <td><?= $this->Number->format($detalleventa->id) ?></td>
                <td><?= $detalleventa->has('producto') ? $this->Html->link($detalleventa->producto->id, ['controller' => 'Productos', 'action' => 'view', $detalleventa->producto->id]) : '' ?></td>
                <td><?= $this->Number->format($detalleventa->precio) ?></td>
                <td><?= $this->Number->format($detalleventa->cantidad) ?></td>
                <td><?= $this->Number->format($detalleventa->porcentajedescuento) ?></td>
                <td><?= $this->Number->format($detalleventa->importedescuento) ?></td>
                <td><?= $this->Number->format($detalleventa->subtotal) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $detalleventa->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $detalleventa->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $detalleventa->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detalleventa->id)]) ?>
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
