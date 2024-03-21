<?php
echo $this->Html->script('cajas/add', ['block' => true]);
$this->Html->css([
    'AdminLTE./plugins/daterangepicker/daterangepicker',
    'AdminLTE./plugins/datepicker/datepicker3',
    'AdminLTE./plugins/iCheck/all',
    'AdminLTE./plugins/colorpicker/bootstrap-colorpicker.min',
    'AdminLTE./plugins/timepicker/bootstrap-timepicker.min',
    'AdminLTE./plugins/select2/select2.min',
  ],
  ['block' => 'css']);
$this->Html->script([
  'AdminLTE./plugins/select2/select2.full.min',
  'AdminLTE./plugins/input-mask/jquery.inputmask',
  'AdminLTE./plugins/input-mask/jquery.inputmask.date.extensions',
  'AdminLTE./plugins/input-mask/jquery.inputmask.extensions',
  'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
  'AdminLTE./plugins/daterangepicker/daterangepicker',
  'AdminLTE./plugins/datepicker/bootstrap-datepicker',
  'AdminLTE./plugins/colorpicker/bootstrap-colorpicker.min',
  'AdminLTE./plugins/timepicker/bootstrap-timepicker.min',
  'AdminLTE./plugins/iCheck/icheck.min',
],
['block' => 'script']);
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Caja $caja
 */
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">                  
                  <h3><?= __('Abrir Caja') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="pagos index large-9 medium-8 columns content">
                    <?= $this->Form->create($caja,[
                        'id' => "formAgregarCaja", 
                        'class'=>'form-control-horizontal',
                        'action'=>'add'
                    ]) ?>
                        <?php
                            echo $this->Form->control('user_id', [
                                'type' => 'hidden', 
                                'value' => $AuthUserId
                            ]);
                            echo $this->Form->control('puntodeventa_id', [
                                'options' => $puntodeventas, 
                                'empty' => false,
                                'label' => 'Punto de venta'
                            ]);
                            echo $this->Form->control('controlada');
                            $dt = new DateTime("now"); //first argument "must" be a string
                            echo $this->Form->control('apertura', [
                                                    'type'=>'text',
                                                    'default'=>$dt->format('Y-m-d H:i:s'),
                                                    //'label' => false,
                                                    'readonly' => 'readonly',
                                                    'class'=>'form-control pull-right',
                                                    'style'=>'width:150px',
                                                ]);
                            echo $this->Form->control('importeapertura');
                            echo $this->Form->control('descripcionapertura',['value'=>'sin novedades','style'=>'width:250px']);
                           
                        ?>
                    <?= $this->Form->button(__('Abrir Caja')) ?>
                    <?= $this->Form->end() ?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
