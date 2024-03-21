<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rubro $rubro
 */
?>
<div class="rubros form large-9 medium-8 columns content">
    <?= $this->Form->create($rubro) ?>
    <fieldset>
        <legend><?= __('Editar Rubro') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Modificar')) ?>
    <?= $this->Form->end() ?>
</div>
