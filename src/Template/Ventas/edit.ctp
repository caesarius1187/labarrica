<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venta $venta
 */
?>
<div class="ventas form large-9 medium-8 columns content">
    <?= $this->Form->create($venta) ?>
    <fieldset>
        <legend><?= __('Editar Venta') ?></legend>
        <?php
            echo $this->Form->control('presupuesto');
            echo $this->Form->control('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->control('puntodeventa_id', ['options' => $puntodeventas, 'empty' => true]);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('fecha', ['empty' => true]);
            echo $this->Form->control('neto');
            echo $this->Form->control('porcentajedescuento');
            echo $this->Form->control('importedescuento');
            echo $this->Form->control('iva');
            echo $this->Form->control('total');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Modificar')) ?>
    <?= $this->Form->end() ?>
</div>
