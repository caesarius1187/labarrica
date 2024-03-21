<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venta[]|\Cake\Collection\CollectionInterface $productos
 */
echo $this->Html->script('table2excel',array('inline'=>false));
echo $this->Html->script('rubros/resumen', ['block' => true]);

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
    
  });
  
</script>
<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <?php
                    
                    echo $this->Form->create($rubro,[
                            'id' => "formListarVenta", 
                            'class'=>'form-control-horizontal',
                            ]) ?>
                    <fieldset>
                        <legend><?= __('Ventas desde '.date('d-m-Y',strtotime($fechaRubrosinicio))." hasta ".date('d-m-Y',strtotime($fechaRubrosfin))) ?> 
                        </legend>
                        <?php
                             echo $this->Form->control('fechainicio', [
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
                             echo $this->Form->control('fechafin', [
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
                    
                     <?php 
                     echo $this->Form->button(__('ver'),[
                            'style'=>'vertical-align: bottom;'
                          ]) ;
                     echo $this->Form->button('Excel',
                                array('type' => 'button',
                                    'id'=>"clickExcel",
                                    'class' =>"btn btn-success btn_imprimir ",
                                    'style'=>'vertical-align: bottom;'
                                )
                            );
                    echo $this->Form->end(); 
                    ?>    
                   </fieldset>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="productos index large-9 medium-8 columns content">
                     <?php 
                        $misProductos = [];
                        foreach ($ventas as $venta){
                            foreach ($venta['detalleventas'] as $detalle){ 
                                $rubroId = $detalle['producto']['rubro_id'];
                                $tipoPrecio=$detalle->tipoprecio;
                                if(!isset($misProductos[$rubroId])){
                                    $misProductos[$rubroId]=[];
                                   
                                }
                                if(!isset($misProductos[$rubroId][$tipoPrecio])){
                                    $misProductos[$rubroId][$tipoPrecio]=[];
                                    $misProductos[$rubroId][$tipoPrecio]['nombre']=$detalle['producto']['rubro']['nombre'];
                                    $misProductos[$rubroId][$tipoPrecio]['costo']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['ganancia']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['precio']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['costopromedio']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['gananciapromedio']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['preciopromedio']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['cantidad']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['porcentajedescuento']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['importedescuento']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['subtotal']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['cantDetalles']=0;
                                    $misProductos[$rubroId][$tipoPrecio]['costoReal']=0;
                                }
                                $misProductos[$rubroId][$tipoPrecio]['costo'] += $detalle->costo;
                                $misProductos[$rubroId][$tipoPrecio]['precio'] += $detalle->precio;
                                $misProductos[$rubroId][$tipoPrecio]['cantidad'] += $detalle->cantidad;
                                $misProductos[$rubroId][$tipoPrecio]['subtotal'] += $detalle->subtotal;
                                $misProductos[$rubroId][$tipoPrecio]['cantDetalles'] ++ ;
                                $misProductos[$rubroId][$tipoPrecio]['costoReal'] += $detalle->costo * $detalle->cantidad;
                            }        
                        }?>
                    <table cellpadding="10" cellspacing="10" id="tblRubrosResumen" class="toExcelTable">
                        <thead>
                            <tr>
                                <th scope="col">Nombre y Tipo Precio</th>
                                <th scope="col">Q. Ventas</th>
                                <th scope="col">Q. Un.Vendidas</th>
                                <th scope="col" class="sum">Compras</th>
                                <th scope="col" class="sum">Ventas</th>
                                <th scope="col" class="sum">Margen Bruto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($misProductos as $misTipoPrecio){ 
                                foreach ($misTipoPrecio as $kmpr => $misProducto){ 
                                    $cantDetalles = $misProducto['cantidad'];
                                    $costoReal = $misProducto['costoReal'];
                                    ?>
                                    <tr>
                                        <td><?= $misProducto['nombre']."-".$kmpr ?></td>
                                        <td><?= $misProducto['cantDetalles'] ?></td>
                                        <td><?= $misProducto['cantidad'] ?></td>
                                        <td><?= number_format($costoReal,2,',','') ?></td>
                                        <td><?= number_format($misProducto['subtotal'],2,',','') ?></td>
                                        <td><?= number_format(($misProducto['subtotal']-$costoReal),2,',','') ?></td>
                                    </tr> 
                                <?php }; ?>
                            <?php }; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Totales</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
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

