<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cliente $cliente
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cliente->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cliente->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ventas'), ['controller' => 'Ventas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Venta'), ['controller' => 'Ventas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientes form large-9 medium-8 columns content">
    <?= $this->Form->create($cliente) ?>
    <fieldset>
        <legend><?= __('Edit Cliente') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('condicioniva',[
                'options'=>[
                   1=>"IVA Responsable Inscripto",
                   4=>"IVA Sujeto Exento",
                   5=>"Consumidor Final",
                   6=>"Responsable Monotributo",
                   8=>"Proveedor del Exterior",
                   9=>"Cliente del Exterior",
                   10=>"IVA Liberado - Ley Nº 19.640",
                   11=>"IVA Responsable Inscripto - Agente de Percepción",
                   13=>"Monotributista Social",
                   15=>"IVA No Alcanzado",
                ]
            ]);
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
