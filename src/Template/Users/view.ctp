<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cajas'), ['controller' => 'Cajas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Caja'), ['controller' => 'Cajas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ventas'), ['controller' => 'Ventas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Venta'), ['controller' => 'Ventas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Dni') ?></th>
            <td><?= h($user->dni) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefono') ?></th>
            <td><?= h($user->telefono) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cel') ?></th>
            <td><?= h($user->cel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mail') ?></th>
            <td><?= h($user->mail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($user->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Matricula') ?></th>
            <td><?= h($user->matricula) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Folio') ?></th>
            <td><?= h($user->folio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo') ?></th>
            <td><?= h($user->tipo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado') ?></th>
            <td><?= h($user->estado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estudio Id') ?></th>
            <td><?= $this->Number->format($user->estudio_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Cajas') ?></h4>
        <?php if (!empty($user->cajas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Puntodeventas Id') ?></th>
                <th scope="col"><?= __('Apertura') ?></th>
                <th scope="col"><?= __('Importeapertura') ?></th>
                <th scope="col"><?= __('Cierre') ?></th>
                <th scope="col"><?= __('Importecierre') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->cajas as $cajas): ?>
            <tr>
                <td><?= h($cajas->id) ?></td>
                <td><?= h($cajas->user_id) ?></td>
                <td><?= h($cajas->puntodeventas_id) ?></td>
                <td><?= h($cajas->apertura) ?></td>
                <td><?= h($cajas->importeapertura) ?></td>
                <td><?= h($cajas->cierre) ?></td>
                <td><?= h($cajas->importecierre) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Cajas', 'action' => 'view', $cajas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Cajas', 'action' => 'edit', $cajas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cajas', 'action' => 'delete', $cajas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cajas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Ventas') ?></h4>
        <?php if (!empty($user->ventas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Presupuesto') ?></th>
                <th scope="col"><?= __('Cliente Id') ?></th>
                <th scope="col"><?= __('Puntodeventa Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Fecha') ?></th>
                <th scope="col"><?= __('Neto') ?></th>
                <th scope="col"><?= __('Porcentajedescuento') ?></th>
                <th scope="col"><?= __('Importedescuento') ?></th>
                <th scope="col"><?= __('Iva') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->ventas as $ventas): ?>
            <tr>
                <td><?= h($ventas->id) ?></td>
                <td><?= h($ventas->presupuesto) ?></td>
                <td><?= h($ventas->cliente_id) ?></td>
                <td><?= h($ventas->puntodeventa_id) ?></td>
                <td><?= h($ventas->user_id) ?></td>
                <td><?= h($ventas->fecha) ?></td>
                <td><?= h($ventas->neto) ?></td>
                <td><?= h($ventas->porcentajedescuento) ?></td>
                <td><?= h($ventas->importedescuento) ?></td>
                <td><?= h($ventas->iva) ?></td>
                <td><?= h($ventas->total) ?></td>
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
