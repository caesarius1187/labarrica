<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Extraccione $extraccione
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Extraccione'), ['action' => 'edit', $extraccione->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Extraccione'), ['action' => 'delete', $extraccione->id], ['confirm' => __('Are you sure you want to delete # {0}?', $extraccione->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Extracciones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Extraccione'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="extracciones view large-9 medium-8 columns content">
    <h3><?= h($extraccione->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($extraccione->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($extraccione->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Importe') ?></th>
            <td><?= $this->Number->format($extraccione->importe) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Saldo') ?></th>
            <td><?= $this->Number->format($extraccione->saldo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($extraccione->fecha) ?></td>
        </tr>
    </table>
</div>
