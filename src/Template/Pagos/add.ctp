<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pago $pago
 */
?>
<div class="pagos form large-9 medium-8 columns content">
    <?= $this->Form->create($pago) ?>
    <fieldset>
        <legend><?= __('Add Pago') ?></legend>
        <?php
            echo $this->Form->control('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->control('puntosdeventas', ['options' => $puntosdeventas, 'empty' => true]);
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
                                    'default'=>$dt->format('d-m-Y, H:i:s'),
                                    //'label' => false,
                                    'readonly' => 'readonly',
                                    'class'=>'form-control pull-right',
                                ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
