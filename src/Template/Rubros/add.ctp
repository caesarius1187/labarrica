<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rubro $rubro
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Rubros'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Productos'), ['controller' => 'Productos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Producto'), ['controller' => 'Productos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rubros form large-9 medium-8 columns content">
    <?= $this->Form->create($rubro) ?>
    <fieldset>
        <legend><?= __('Add Rubro') ?></legend>
        <?php
            echo $this->Form->control('nombre',[
                    'type'=>'text'
                ]);
            echo $this->Form->control('descripcion',[
                    'type'=>'text'
                ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
