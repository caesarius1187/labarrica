<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venta[]|\Cake\Collection\CollectionInterface $productos
 */
echo $this->Html->script('table2excel',array('inline'=>false));
echo $this->Html->script('productos/resumen', ['block' => true]);

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
 
</script>
<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php
                    
                    echo $this->Form->create($producto,[
                            'id' => "formListarVenta", 
                            'class'=>'form-control-horizontal',
                            ]) ?>
                    <fieldset>
                        <legend><?= __('Ventas desde '.date('d-m-Y',strtotime($fechaProductosinicio))." hasta ".date('d-m-Y',strtotime($fechaProductosfin))) ?> 
                        </legend>
                        <?php
                             echo $this->Form->control('fechadesde', [
                                    'label'=>'Desde',
                                    'type'=>'text',
                                    'default'=>date('01-m-Y'),
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
                                    'label'=>'Hasta',
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
                          echo $this->Form->button(__('ver'),[
                            'style'=>'vertical-align: bottom;'
                          ]) ;
                           echo $this->Form->button('Excel',
                                array('type' => 'button',
                                    'id'=>"clickExcel",
                                    'class' =>"btn btn-success btn_imprimir ",
                                    'style'=>'vertical-align: bottom;'
                                )
                            );?>

                    </fieldset>
                  
                    <?= $this->Form->end() ?>    
                   
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="productos index large-9 medium-8 columns content">
                     <?php 
                        $misProductos = [];           
                        foreach ($ventas as $venta){
                            foreach ($venta['detalleventas'] as $detalle){ 
                                $productoId=$detalle['producto']['id'];
                                $tipoPrecio=$detalle->tipoprecio;
                                if(!isset($misProductos[$productoId])){
                                    $misProductos[$productoId]=[];
                                   
                                }
                                if(!isset($misProductos[$productoId][$tipoPrecio])){
                                    $misProductos[$productoId][$tipoPrecio]=[];
                                    $misProductos[$productoId][$tipoPrecio]['nombre']=$detalle['producto']['nombre'];
                                    $misProductos[$productoId][$tipoPrecio]['costo']=0;
                                    $misProductos[$productoId][$tipoPrecio]['ganancia']=0;
                                    $misProductos[$productoId][$tipoPrecio]['precio']=0;
                                    $misProductos[$productoId][$tipoPrecio]['costopromedio']=0;
                                    $misProductos[$productoId][$tipoPrecio]['gananciapromedio']=0;
                                    $misProductos[$productoId][$tipoPrecio]['preciopromedio']=0;
                                    $misProductos[$productoId][$tipoPrecio]['cantidad']=0;
                                    $misProductos[$productoId][$tipoPrecio]['porcentajedescuento']=0;
                                    $misProductos[$productoId][$tipoPrecio]['importedescuento']=0;
                                    $misProductos[$productoId][$tipoPrecio]['subtotal']=0;
                                    $misProductos[$productoId][$tipoPrecio]['cantDetalles']=0;
                                    $misProductos[$productoId][$tipoPrecio]['costoReal']=0;
                                }
                                $misProductos[$productoId][$tipoPrecio]['costo'] += $detalle->costo;
                                $misProductos[$productoId][$tipoPrecio]['ganancia'] += $detalle->precio*1-$detalle->costo*1;
                                $misProductos[$productoId][$tipoPrecio]['precio'] += $detalle->precio;

                                $misProductos[$productoId][$tipoPrecio]['costopromedio'] += $detalle->costo*$detalle->cantidad;
                                $misProductos[$productoId][$tipoPrecio]['gananciapromedio'] += ($detalle->precio*1-$detalle->costo)*1*$detalle->cantidad;
                                $misProductos[$productoId][$tipoPrecio]['preciopromedio'] += $detalle->precio*$detalle->cantidad;

                                $misProductos[$productoId][$tipoPrecio]['cantidad'] += $detalle->cantidad;
                                $misProductos[$productoId][$tipoPrecio]['porcentajedescuento'] += $detalle->porcentajedescuento;
                                $misProductos[$productoId][$tipoPrecio]['importedescuento'] += $detalle->importedescuento;
                                $misProductos[$productoId][$tipoPrecio]['subtotal'] += $detalle->subtotal;
                                $misProductos[$productoId][$tipoPrecio]['cantDetalles'] ++ ;
                                $misProductos[$productoId][$tipoPrecio]['costoReal'] += $detalle->costo * $detalle->cantidad;
                            }        
                        } 
                        ?>
                    <table cellpadding="10" cellspacing="10" id="tblProductosResumen" class="toExcelTable">
                        <thead>
                            <tr>
                                <th >Nombre y Tipo Precio</th>
                                <th >Ventas</th>
                                <th >Cantidad</th>
                                <th >Desc</th>
                                <th class="sum">Subtotal Costo</th>
                                <th class="sum">Subtotal Venta</th>
                                <th class="sum">Ganancia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalCostos=0;
                            $totalVentas=0;
                            $totalGanancias=0;

                            foreach ($misProductos as $misTipoPrecio){ 
                                foreach ($misTipoPrecio as $kmpr => $misProducto){ 
                                    $cantDetalles = $misProducto['cantidad'];
                                    if($cantDetalles==0)$cantDetalles=1;
                                    $costoReal = $misProducto['costoReal'];
                                    ?>
                                    <tr>
                                        <td><?= $misProducto['nombre']."-".$kmpr ?></td>
                                        <td><?= $misProducto['cantDetalles'] ?></td>
                                        <td><?= $misProducto['cantidad'] ?></td>
                                        <td><?= number_format($misProducto['importedescuento'],2,',','') ?></td>
                                        <td><?= number_format($costoReal,2,',','') ?></td>
                                        <td><?= number_format($misProducto['subtotal'],2,',','') ?></td>
                                        <td><?= number_format(($misProducto['subtotal']-$costoReal),2,',','') ?></td>
                                    </tr> 
                                <?php 
                                    $totalCostos+=$costoReal;
                                    $totalVentas+=$misProducto['subtotal'];
                                    $totalGanancias+=$misProducto['subtotal']-$costoReal;
                                    };  ?>
                            <?php }; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th >Totales</th><!--1-->
                                <th ></th><!--2-->
                                <th ></th><!--3-->
                                <th ></th><!--4-->
                                <th ><?= number_format($totalCostos,2,',',''); ?></th><!--5-->
                                <th ><?= number_format($totalVentas,2,',',''); ?></th><!--6-->
                                <th ><?= number_format($totalGanancias,2,',',''); ?></th><!--7-->                                
                            </tr>
                        </tfoot>
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
