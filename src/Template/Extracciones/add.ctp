<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Extraccione $extraccione
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Extracciones'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="extracciones form large-9 medium-8 columns content">
    <?= $this->Form->create($extraccione) ?>
    <fieldset>
        <legend><?= __('Add Extraccione') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
            echo $this->Form->control('importe');
            echo $this->Form->control('user_id', [
                                    'value' => $AuthUserId, 
                                    'type' => 'text'
                                ]);
            $tz = '-0300';
            $timestamp = time();
            $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            echo $this->Form->control('fecha', [
                                    'type'=>'text',
                                    'default'=>$dt->format('d.m.Y, H:i:s'),
                                    //'label' => false,
                                    'readonly' => 'readonly',
                                    'class'=>'form-control pull-right',
                                ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Registrar Extraccion')) ?>
    <?= $this->Form->end() ?>
</div>
