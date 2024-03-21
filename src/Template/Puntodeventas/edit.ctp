<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puntodeventa $puntodeventa
 */
?>
<div class="puntodeventas form large-9 medium-8 columns content">
    <?= $this->Form->create($puntodeventa) ?>
    <fieldset>
        <legend><?= __('Editar Punto de venta') ?></legend>
        <?php
            echo $this->Form->control('numero');
            echo $this->Form->control('nombre');
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Modificar')) ?>
    <?= $this->Form->end() ?>
</div>
