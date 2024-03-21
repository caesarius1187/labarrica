<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Caja $caja
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Caja'), ['action' => 'edit', $caja->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Caja'), ['action' => 'delete', $caja->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caja->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cajas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Caja'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Puntodeventas'), ['controller' => 'Puntodeventas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Puntodeventa'), ['controller' => 'Puntodeventas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cajas view large-9 medium-8 columns content">
    <h3><?= h($caja->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $caja->has('user') ? $this->Html->link($caja->user->id, ['controller' => 'Users', 'action' => 'view', $caja->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Puntodeventa') ?></th>
            <td><?= $caja->has('puntodeventa') ? $this->Html->link($caja->puntodeventa->id, ['controller' => 'Puntodeventas', 'action' => 'view', $caja->puntodeventa->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($caja->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Importeapertura') ?></th>
            <td><?= $this->Number->format($caja->importeapertura) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Importecierre') ?></th>
            <td><?= $this->Number->format($caja->importecierre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Apertura') ?></th>
            <td><?= h($caja->apertura) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cierre') ?></th>
            <td><?= h($caja->cierre) ?></td>
        </tr>
    </table>
</div>
