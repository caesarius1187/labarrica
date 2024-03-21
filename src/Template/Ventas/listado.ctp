<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venta[]|\Cake\Collection\CollectionInterface $ventas
 */
$this->Html->css([
    'AdminLTE./plugins/datepicker/datepicker3',
    'AdminLTE./plugins/datatables/dataTables.bootstrap',
  ],
  ['block' => 'css']);

$this->Html->script([
    'AdminLTE./plugins/datatables/jquery.dataTables.min',
    'AdminLTE./plugins/datepicker/bootstrap-datepicker',
    'AdminLTE./plugins/datatables/dataTables.bootstrap.min',
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
  $(function () {
    //$("#tblVentas").DataTable();
  });
  $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });
</script>
<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php
                    echo $this->Form->button(
                        'Agregar', 
                        array(
                            'onclick' => "window.location.href='".Router::url(
                                array(
                                    'controller' => 'ventas',
                                    'action' => 'listado')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',                            
                        )
                    );
                    echo $this->Form->create($venta,[
                            'id' => "formListarVenta", 
                            'class'=>'form-control-horizontal',
                            ]) ?>
                    <fieldset>
                        <legend>
                            <?= __('Ventas desde el dia '.date('d-m-Y',strtotime($fechaVentasDesde))) ?> 
                            <?= __(' hasta el dia '.date('d-m-Y',strtotime($fechaVentasHasta))) ?> 
                        </legend>
                        <?php
                             echo $this->Form->control('fecha', [
                                    'label'=>'Fecha desde',
                                    'type'=>'text',
                                    'default'=>date('d-m-Y'),
                                    //'label' => false,
                                    'empty' => true,
                                    'class'=>'form-control pull-right datepicker',
                                    'templates' => [
                                        'inputContainer' => '
                                            <div class="input-group date">
                                                {{content}}
                                            </div>'
                                    ],
                                ]);
                              echo $this->Form->control('fechahasta', [
                                    'label'=>'Fecha hasta',
                                    'type'=>'text',
                                    'default'=>date('d-m-Y'),
                                    //'label' => false,
                                    'empty' => true,
                                    'class'=>'form-control pull-right datepicker',
                                    'templates' => [
                                        'inputContainer' => '
                                            <div class="input-group date">
                                                {{content}}
                                            </div>'
                                    ],
                                ]);
                        ?>
                      <?= $this->Form->button(__('ver otra fecha'),[
                        'style'=>'vertical-align: bottom;'
                      ]) ?>
                    </fieldset>
                  
                    <?= $this->Form->end() ?>    
                   
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="ventas index large-9 medium-8 columns content">
                    <table cellpadding="0" cellspacing="0" id="tblVentas">                     
                        <?php foreach ($ventas as $kv => $venta): ?>
                            <tr style="border: black 1px solid;">
                                <th>numero</th>
                                <th>fecha</th>
                                <th>creada</th>
                                <th>cliente</th>
                                <th>punto de venta</th>
                                <th>neto</th>
                                <th>% desc</th>
                                <th>$ desc</th>
                                <th>total</th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>    
                            <tr style="border: black 1px dotted;">
                                <td><?= $this->Number->format($venta->numero) ?></td>
                                <td><?= h(date('d-m-Y',strtotime($venta->fecha))) ?></td>
                                <td><?= date('H:i',strtotime($venta->created)) ?></td>
                                <td><?= $venta->has('cliente') ? $venta->cliente->nombre : '' ?></td>
                                <td><?php 
                                    $numeroPDV = "";
                                    if(isset($venta->puntodeventa)){
                                        $numeroPDV = str_pad($venta->puntodeventa->numero, 5, "0", STR_PAD_LEFT);
                                    }
                                    echo $numeroPDV;
                                    ?></td>
                                <td><?= $this->Number->format($venta->neto) ?></td>
                                <td><?= $this->Number->format($venta->porcentajedescuento) ?></td>
                                <td><?= $this->Number->format($venta->importedescuento) ?></td>
                                <td><?= $this->Number->format($venta->total) ?></td>
                                <td class="actions">
                                    <?php 
                                    $iconoPrint = '<i class="fa fa-print"></i>';
                                    echo $this->Html->link($iconoPrint, [
                                            'action' => 'view', $venta->id
                                        ],
                                        [
                                            'escape' => false,
                                        ]  
                                    ); 
                                    $iconoTrash = '<i class="fa fa-trash"></i>';
                                    echo $this->Form->postLink(
                                        $iconoTrash,
                                            ['action' => 'delete', $venta->id,], 
                                            [
                                                'confirm' => __('Esta seguro que desea eliminar la venta # {0}?', $venta->numero),
                                                'escape' => false,
                                            ],                                                
                                            ['class' =>'btn btn-app-select',]
                                        ) ?>
                                </td>
                            </tr>
                            <tr style="border: black 1px solid;">
                                <th>Codigo</th>
                                <th colspan="4">Nombre</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>PorDesc</th>
                                <th>ImpDesc</th>
                                <th>Subtotal</th>
                            </tr>
                            <?php 
                            foreach ($venta['detalleventas'] as $kdt => $dv) { ?>
                                <tr style="border: black 1px dotted;">
                                    <td>
                                    <?php
                                        echo $dv['producto']['codigo']
                                    ?>
                                    </td>
                                    <td colspan="4">
                                    <?php
                                        echo $dv['producto']['nombre'];
                                    ?>
                                    </td>
                                    <td class="tdWithNumber">
                                    <?php
                                        echo number_format($dv['cantidad'], 2, ",", ".");;
                                    ?>
                                    </td>
                                    <td class="tdWithNumber">
                                    <?php
                                        echo number_format($dv['precio'], 2, ",", ".");;
                                    ?>
                                    </td>
                                    <td class="tdWithNumber">
                                    <?php
                                        echo number_format($dv['porcentajedescuento'], 2, ",", ".");;
                                    ?>
                                    </td>
                                    <td class="tdWithNumber">
                                    <?php
                                        echo number_format($dv['importedescuento'], 2, ",", ".");;
                                    ?>
                                    </td>
                                    <td class="tdWithNumber">
                                    <?php
                                        echo number_format($dv['subtotal'], 2, ",", ".");;
                                    ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                           
                            <tr style="border: black 1px solid;">
                                <td colspan="2">Forma de Pago</td>
                                <?php
                                foreach ($venta['pagos'] as $kp => $pago) { ?>
                                    <td>
                                    <?php
                                        echo $pago['metodo']
                                    ?>
                                    </td>
                                <?php
                                }
                                ?>
                            </tr>    
                            <tr><td colspan="20"><hr style="border: white dotted 1px;"></td></tr>
                            <?php 
                            //if($kv>100)return;
                            endforeach; ?>
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

