<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Caja[]|\Cake\Collection\CollectionInterface $cajas
 */
echo $this->Html->script('cajas/index', ['block' => true]);
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= __('Vendedor '.$AuthUserNombre) ?></h3> 
                    <?php
                    if(isset($micaja['puntodeventa'])){
                        ?>
                    <h3 class="box-title">Punto de Venta ::</h3> <?php echo str_pad($micaja['puntodeventa']['numero'], 5, "0", STR_PAD_LEFT); 
                   }?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="cajas index large-9 medium-8 columns content">
                        <h3><?= __('Cajas') ?></h3>
                        <table cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Controlada</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Punto de Venta</th>
                                    <th scope="col">Apertura</th>
                                    <th scope="col">Importe apertura</th>
                                    <th scope="col">Cierre</th>
                                    <th scope="col">Importe Cierre</th>
                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cajas as $caja): ?>
                                <tr>
                                     <td>
                                          <?= $this->Form->create($caja,[
                                                'id' => "formControlarCaja".$caja->id, 
                                                'class'=>'form-control-horizontal controlarCajaForm',
                                                'action'=>'controlar'
                                            ]) ?>
                                        <?php
                                            echo $this->Form->control('id', [
                                                'id'=>'RBContoladaId'.$caja->id,
                                                'type' => 'hidden', 
                                                'value' => $caja->id
                                            ]);
                                            echo $this->Form->checkbox('controlada',[
                                                'label'=>false,
                                                'class'=>'controlada',
                                                'type'=> 'radio',
                                                'checked'=> ($caja->controlada!=null||$caja->controlada!=0),
                                                'onChange'=>'controlar('.$caja->id.')',
                                                'style'=>'position: inherit !important; margin: 0px !important ',
                                            ]);         
                                        ?>
                                        <?= $this->Form->end() ?>
                                    </td>
                                    <td><?= $caja->has('user') ? $this->Html->link($caja->user->first_name, ['controller' => 'Users', 'action' => 'view', $caja->user->id]) : '' ?></td>
                                    <?php
                                    $nombrePuntodeventas = str_pad($caja->puntodeventa->numero, 5, "0", STR_PAD_LEFT)." ".$caja->puntodeventa->nombre;
                                    ?>
                                    <td><?= $caja->has('puntodeventa') ? $this->Html->link(
                                        $nombrePuntodeventas, ['controller' => 'Puntodeventas', 'action' => 'view', $caja->puntodeventa->id]) : '' ?></td>
                                    <td><?= h($caja->apertura) ?></td>
                                    <td><?= $this->Number->format($caja->importeapertura) ?></td>
                                    <td><?= h($caja->cierre) ?></td>
                                    <td><?= $this->Number->format($caja->importecierre) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $caja->id]) ?>
                                        <?= $this->Html->link(__('Cerrar'), ['action' => 'cerrar', $caja->id]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>                      
                    </div>
                </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
