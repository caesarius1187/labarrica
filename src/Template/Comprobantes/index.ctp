<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comprobante[]|\Cake\Collection\CollectionInterface $comprobantes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Comprobante'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ventas'), ['controller' => 'Ventas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Venta'), ['controller' => 'Ventas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="comprobantes index large-9 medium-8 columns content">
    <h3><?= __('Comprobantes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('codigo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipodebitoasociado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipocreditoasociado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('abreviacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('abreviacion2') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comprobantes as $comprobante): ?>
            <tr>
                <td><?= $this->Number->format($comprobante->id) ?></td>
                <td><?= h($comprobante->nombre) ?></td>
                <td><?= h($comprobante->codigo) ?></td>
                <td><?= h($comprobante->tipo) ?></td>
                <td><?= h($comprobante->tipodebitoasociado) ?></td>
                <td><?= h($comprobante->tipocreditoasociado) ?></td>
                <td><?= h($comprobante->abreviacion) ?></td>
                <td><?= h($comprobante->abreviacion2) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $comprobante->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $comprobante->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $comprobante->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comprobante->id)]) ?>
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
