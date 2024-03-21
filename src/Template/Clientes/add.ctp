<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cliente $cliente
 */
?>
<div class="clientes form large-9 medium-8 columns content">
    <?= $this->Form->create($cliente) ?>
    <fieldset>
        <legend><?= __('Agregar Cliente/Provedor') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('mail');
            echo $this->Form->control('telefono');
            echo $this->Form->control('celular');
            echo $this->Form->control('direccion');
            echo $this->Form->control('DNI');
            echo $this->Form->control('CUIT');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
