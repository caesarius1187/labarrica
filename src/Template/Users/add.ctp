<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cajas'), ['controller' => 'Cajas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Caja'), ['controller' => 'Cajas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ventas'), ['controller' => 'Ventas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Venta'), ['controller' => 'Ventas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('dni');
            echo $this->Form->control('telefono');
            echo $this->Form->control('cel');
            echo $this->Form->control('mail');
            echo $this->Form->control('nombre');
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('role',[
                'type'=>'select',
                'options'=>[
                    'administrador'=>'Administrador',
                    'cliente'=>'Cliente',
                    'operario'=>'Operario',
                    'superadministrador'=>'Superadministrador'
                ]
            ]);
            
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
