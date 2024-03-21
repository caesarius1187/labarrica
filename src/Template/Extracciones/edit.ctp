<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Extraccione $extraccione
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $extraccione->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $extraccione->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Extracciones'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="extracciones form large-9 medium-8 columns content">
    <?= $this->Form->create($extraccione) ?>
    <fieldset>
        <legend><?= __('Edit Extraccione') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
            echo $this->Form->control('importe');
            echo $this->Form->control('saldo');
            echo $this->Form->control('fecha', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
