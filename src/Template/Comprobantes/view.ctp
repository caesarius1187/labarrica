<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comprobante $comprobante
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Comprobante'), ['action' => 'edit', $comprobante->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Comprobante'), ['action' => 'delete', $comprobante->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comprobante->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Comprobantes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comprobante'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ventas'), ['controller' => 'Ventas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Venta'), ['controller' => 'Ventas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="comprobantes view large-9 medium-8 columns content">
    <h3><?= h($comprobante->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($comprobante->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Codigo') ?></th>
            <td><?= h($comprobante->codigo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo') ?></th>
            <td><?= h($comprobante->tipo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipodebitoasociado') ?></th>
            <td><?= h($comprobante->tipodebitoasociado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipocreditoasociado') ?></th>
            <td><?= h($comprobante->tipocreditoasociado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abreviacion') ?></th>
            <td><?= h($comprobante->abreviacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abreviacion2') ?></th>
            <td><?= h($comprobante->abreviacion2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($comprobante->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ventas') ?></h4>
        <?php if (!empty($comprobante->ventas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Presupuesto') ?></th>
                <th scope="col"><?= __('Cliente Id') ?></th>
                <th scope="col"><?= __('Comprobante Id') ?></th>
                <th scope="col"><?= __('Puntodeventa Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Numero') ?></th>
                <th scope="col"><?= __('Fecha') ?></th>
                <th scope="col"><?= __('Neto') ?></th>
                <th scope="col"><?= __('Porcentajedescuento') ?></th>
                <th scope="col"><?= __('Importedescuento') ?></th>
                <th scope="col"><?= __('Iva') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col"><?= __('Cobrado') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($comprobante->ventas as $ventas): ?>
            <tr>
                <td><?= h($ventas->id) ?></td>
                <td><?= h($ventas->presupuesto) ?></td>
                <td><?= h($ventas->cliente_id) ?></td>
                <td><?= h($ventas->comprobante_id) ?></td>
                <td><?= h($ventas->puntodeventa_id) ?></td>
                <td><?= h($ventas->user_id) ?></td>
                <td><?= h($ventas->numero) ?></td>
                <td><?= h($ventas->fecha) ?></td>
                <td><?= h($ventas->neto) ?></td>
                <td><?= h($ventas->porcentajedescuento) ?></td>
                <td><?= h($ventas->importedescuento) ?></td>
                <td><?= h($ventas->iva) ?></td>
                <td><?= h($ventas->total) ?></td>
                <td><?= h($ventas->cobrado) ?></td>
                <td><?= h($ventas->created) ?></td>
                <td><?= h($ventas->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Ventas', 'action' => 'view', $ventas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Ventas', 'action' => 'edit', $ventas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ventas', 'action' => 'delete', $ventas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ventas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
