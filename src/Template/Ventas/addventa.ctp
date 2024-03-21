<?php
use Cake\Routing\Router;

echo $this->Form->control('cantDetalle', [
    'type' => 'hidden', 
    'value' => 0, 
]);  
$this->Form->unlockField('cantDetalle');

echo $this->Form->control('allproductos', [
    'value' => "", 
    'type'=>'hidden'
    ]);
$this->Form->unlockField('allproductos');


echo $this->Html->script('ventas/add', ['block' => true]);
$this->Html->css([
    'AdminLTE./plugins/datepicker/datepicker3',
    'AdminLTE./plugins/select2/select2.min',
  ],
  ['block' => 'css']);
$this->Html->script([
    'AdminLTE./plugins/select2/select2.full.min',
    'AdminLTE./plugins/datepicker/bootstrap-datepicker',
],
['block' => 'script']);
echo $this->Form->input('productoslista', [
    'type' => 'select', 
    'label' => false, 
    'style' => 'display:none;margin-bottom:0px;', 
    'options' => $productos, 
    'div'=>[
        'style' => 'display:none;margin-bottom:0px;', 
    ]
]);  
$this->Form->unlockField('productoslista');

echo $this->Form->input('urlBuild', [
    'type' => 'hidden', 
    'value' => $this->Url->build( [ 'controller' => 'Productos', 'action' => 'search' ] ), 
]);  

$this->Form->unlockField('urlBuild');
echo $this->Form->input('urlBuildAutocomplete', [
    'type' => 'hidden', 
    'value' => $this->Url->build( [ 'controller' => 'Productos', 'action' => 'autoComplete' ] ), 
]);  
$this->Form->unlockField('urlBuildAutocomplete');
//debug(json_encode($allproductos, JSON_PRETTY_PRINT));
/*$productsIterator =  json_encode($allproductos, JSON_PRETTY_PRINT);
foreach ($allproductos as $key => $value) {
    # code...
}*/
/*echo $this->Form->input('allproductos', [
    'value' =>json_encode($allproductos->all()), 
    'type'=>'text'
    ]);*/
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="float: left">
                <?php echo $this->Form->create($venta,[
                            'id' => "formAgregarVenta", 
                            'class'=>'form-control-horizontal',
                            'action'=>'addventa'
                        ]);?>

                <div class="box-header">
                    <div class="btn-group-vertical">
                      <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="ulPrintLastSales">
                        </ul>
                      </div>
                    </div>
                    <?php 
                    $nuemeroUltimaventa = $ultimaventa[0]['ultimaventa']*1+1;
                    echo $this->Form->control('numero',[
                                    'value'=>$nuemeroUltimaventa,
                                    'readonly',
                                    'label'=>[
                                        'text'=>'N Venta '.($nuemeroUltimaventa),
                                        'style'=>'margin: 10px;'
                                    ],
                                    'style'=>'display:none',
                                    'templates' => [
                                        'inputContainer' => '<div class="form-group input {{type}}{{required}}" style="border:1px dotted black">{{content}}</div>',
                                    ],
                                ]);
                    $this->Form->unlockField('numero');
                    ?>
                    <h3 class="box-title">Agregar una Venta ::</h3> <?= __('Vendedor '.$AuthUserNombre) ?>
                    <h3 class="box-title">Punto de Venta ::</h3> <?php echo str_pad($micaja['puntodeventa']['numero'], 5, "0", STR_PAD_LEFT); ?>
                    <label style="margin-right: 79px;font-size: 40px;float: right;background: #2196F3;" for="total">Total a Pagar: $0</label>
                </div>
                <!-- /.box-header -->
                <div class="box-body col-xs-8">
                    <div class="ventas index large-9 medium-8 columns content">
                        <fieldset id="fsDetalles">
                            <legend><?= __('Detalle de venta') ?></legend>
                            <?php
                            echo $this->Form->control('buscador',[ 
                                    'style'=>'width:390px',
                                    'type'=>'text',
                                    'disabled'=>true,
                                    //'options' => $productos, 
                                    //'onchange' => 'agregarDetalle();', 
                                    'empty' => true]
                            );
                            ?>
                            <a class="btn btn-app-select" data-toggle="modal" data-target="#modal-primary" style="margin: 0 0 -55px 0px;">
                                <i class="fa fa-plus-square"></i> 
                            </a>
                            <?php
                            echo "</br>";                               
                            $this->Form->unlockField('buscador');
                            unlockDetallefields($this);
                            ?>
                            </br>                               
                        </fieldset>                          
                    </div>
                </div>
                <div class="box-body col-xs-4">
                    <div class="ventas index large-9 medium-8 columns content">
                        <?php
                        //si es presupuesto o no        
                        echo $this->Form->control('id', [
                            'type' => 'hidden', 
                        ]);           
                        $this->Form->unlockField('id');
                        echo $this->Form->control('cliente_id', [
                            'options' => $clientes, 
                            'style' => 'width:250px', 
                            'default' => 1,                                     
                            'empty' => false]);
                        $this->Form->unlockField('cliente_id');
                            ?>
                        <a class="btn btn-app-selector2" data-toggle="modal" data-target="#modal-info" style="margin: 0 0 -62px 0px;">
                            <i class="fa fa-user-plus"></i> 
                        </a>
                        <?php
                        echo $this->Form->control('fecha', [
                            'type'=>'hidden',
                            'default'=>date('d-m-Y'),
                            //'label' => false,
                            'empty' => true,
                            'class'=>'form-control pull-right',
                            'formGroup' => '{{label}} 
                                            {{input}}',
                            'templates' => [
                                'inputContainer' => '
                                    <div class="input-group date">
                                        {{content}}
                                    </div>'
                            ],
                        ]);
                        $this->Form->unlockField('fecha');
                        echo $this->Form->control('presupuesto');         
                        $this->Form->unlockField('presupuesto');
                        //echo $this->Form->control('cobrado');         
                        echo "</br>";
                        //esta tiene que ser de la caja que tiene abierta este usuario
                       
                        echo $this->Form->control('puntodeventa_id', [
                            'value' => $micaja['puntodeventa_id'], 
                            'type' => 'hidden', 
                            'empty' => false]);
                        $this->Form->unlockField('puntodeventa_id');
                        echo $this->Form->control('user_id', [
                            'value' => $AuthUserId, 
                            'type' => 'hidden'
                        ]);                              
                        $this->Form->unlockField('user_id');
                        echo $this->Form->control('neto',['readonly','readonly']);
                        $this->Form->unlockField('neto');
                        echo $this->Form->control('porcentajedescuento',[
                            'label'=>'% Desc',
                            'onchange' => 'agregarDetalle();', 
                        ]);
                        $this->Form->unlockField('porcentajedescuento');

                        echo $this->Form->control('importedescuento',[
                            'label'=>[
                                'text'=>'Total a Descontar: $0',
                            ],
                        ])."</br>";
                        $this->Form->unlockField('importedescuento');
                        echo $this->Form->control('iva',['type'=>'hidden']);
                        $this->Form->unlockField('iva');
                        echo $this->Form->control('total',[
                            'readonly',
                            'label'=>[
                                'text'=>'Total a Pagar: $0',
                                'style'=>'margin: 10px;'
                            ],
                            'style'=>'display:none',
                            'templates' => [
                                'inputContainer' => '<div class="form-group input {{type}}{{required}}" style="border:1px dotted black">{{content}}</div>',
                            ],                                    
                        ]);
                        $this->Form->unlockField('total');
                        ?>
                        <fieldset id="fsPagos">
                            <?php
                            echo $this->Form->control('pagos.numero', [
                                'value'=>$ultimopago[0]['ultimopago']*1+1,
                                'label'=>[
                                    'text'=>'N de Cobro '.($ultimopago[0]['ultimopago']*1+1),
                                    'style'=>'margin: 10px;'
                                ],
                                'style'=>'display:none',
                                'templates' => [
                                    'inputContainer' => '<div class="form-group input {{type}}{{required}}" style="border:1px dotted black">{{content}}</div>',
                                ],
                            ])."</br>";
                            $this->Form->unlockField('pagos.numero');
                            echo $this->Form->control('pagos.cliente_id', [
                                'type'=>'hidden'
                            ]);
                            $this->Form->unlockField('pagos.cliente_id');

                            echo $this->Form->control('pagos.venta_id', [
                                'type'=>'hidden'
                            ]);
                            $this->Form->unlockField('pagos.venta_id');
                            
                            echo $this->Form->control('pagos.tipo', [
                                'type'=>'hidden',
                                'value'=>'cobro'
                            ]);
                            $this->Form->unlockField('pagos.tipo');

                            echo $this->Form->control('pagos.metodo', [
                                'type'=>'select',
                                'options'=>[
                                    'efectivo'=>'Efectivo',
                                    'visa'=>'Visa',
                                    'mastercard'=>'MasterCard',
                                    'cuentacorriente'=>'Cuenta Corriente',
                                    'otros'=>'Otros',
                                ]
                            ]);
                            $this->Form->unlockField('pagos.metodo');
                            echo $this->Form->control('pagos.user_id', [
                                'value' => $AuthUserId, 
                                'type' => 'hidden'
                            ]); 
                            $this->Form->unlockField('pagos.user_id');

                            echo $this->Form->control('pagos.puntodeventa_id', [
                                'type'=>'hidden',
                                'value'=>$micaja['puntodeventa_id'], 
                            ]);
                            $this->Form->unlockField('pagos.puntodeventa_id');

                            echo $this->Form->control('pagos.fecha', [
                                'type'=>'hidden',
                                'default'=>date('d-m-Y'),
                                'label' => false,                                    
                            ]);
                            $this->Form->unlockField('pagos.fecha');
                            echo $this->Form->control('pagos.importe');
                            $this->Form->unlockField('pagos.importe');                                
                            echo $this->Form->control('pagos.descripcion',['style'=>'width:200px']);
                            $this->Form->unlockField('pagos.descripcion');
                            ?>
                            </br>                               
                        </fieldset>      
                    </div>
                </div>
            <!-- /.box-body -->
                <?= $this->Form->button(__('Guardar')) ?>
                <?= $this->Form->end() ?>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<?php
function unlockDetallefields($context){
    for ($i=0; $i < 50; $i++) { 
        $context->Form->unlockField('detalleventas.'.$i.'.id');
        $context->Form->unlockField('detalleventas.'.$i.'.producto_id');
        $context->Form->unlockField('detalleventas.'.$i.'.venta_id');
        $context->Form->unlockField('detalleventas.'.$i.'.precio');
        $context->Form->unlockField('detalleventas.'.$i.'.ganancia');
        $context->Form->unlockField('detalleventas.'.$i.'.costo');
        $context->Form->unlockField('detalleventas.'.$i.'.cantidad');
        $context->Form->unlockField('detalleventas.'.$i.'.porcentajedescuento');
        $context->Form->unlockField('detalleventas.'.$i.'.importedescuento');
        $context->Form->unlockField('detalleventas.'.$i.'.subtotal');
        $context->Form->unlockField('detalleventas.'.$i.'.tipoprecio');
        $context->Form->unlockField('detalleventas.'.$i.'.selectprecio');       
        $context->Form->unlockField('detalleventas.'.$i.'.descripcion');       
    }
}
?>
<div class="modal modal-info fade in" id="modal-info" style="display: none; padding-right: 20px;">
    <div class="modal-dialog">
        <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Agregar Cliente</h4>
              </div>
              <div class="modal-body">
                <?php
                echo $this->Form->create($cliente,[
                            'id' => "formAgregarCliente", 
                            'class'=>'form-control-horizontal',
                            'url'=>[                                
                                'controller'=>'Clientes',
                                'action'=>'add',
                            ]
                        ]);
                        echo $this->Form->control('nombre');
                        echo $this->Form->control('mail');
                        echo $this->Form->control('telefono');
                        echo $this->Form->control('celular');
                        echo $this->Form->control('direccion');
                        echo $this->Form->control('DNI');
                        echo $this->Form->control('CUIT');
                    ?>
                <?= $this->Form->end() ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" onclick='$("#formAgregarCliente").submit()'>Guardar Cliente</button>
              </div>
        </div>
            <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal modal-primary fade in" id="modal-primary" style="display: none; padding-right: 20px;">
    <div class="modal-dialog">
        <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Agregar Producto</h4>
              </div>
              <div class="modal-body">
                <?php
                echo $this->Form->create($producto,[
                            'id' => "formAgregarProducto", 
                            'class'=>'form-control-horizontal',
                            'url'=>[                                
                                'controller'=>'Productos',
                                'action'=>'add',
                            ]
                        ]);
                        echo $this->Form->control('rubro_id', ['options' => $rubros]);
                        echo $this->Form->control('nombre',['style'=>'width:250px;'])."</br>";
                        echo $this->Form->control('costo')."</br>";
                        echo $this->Form->control('ganancia',[]);
                        echo $this->Form->control('precio')."</br>";

                        echo $this->Form->control('gananciapack',['value'=>12]);
                        echo $this->Form->control('preciopack',['label'=>'Precion unidad en pack 0']);
                        echo $this->Form->control('preciopack0')."</br>";

                        echo $this->Form->control('ganancia1',['value'=>12]);
                        echo $this->Form->control('preciomayor1',['label'=>'Precion unidad en pack 1']);
                        echo $this->Form->control('preciopack1')."</br>";

                        echo $this->Form->control('ganancia2',['value'=>11]);
                        echo $this->Form->control('preciomayor2',['label'=>'Precion unidad en pack 2']);
                        echo $this->Form->control('preciopack2')."</br>";

                        echo $this->Form->control('ganancia3',['value'=>10.5]);
                        echo $this->Form->control('preciomayor3',['label'=>'Precion unidad en pack 3']);
                        echo $this->Form->control('preciopack3')."</br>";

                        echo $this->Form->control('ganancia4',['value'=>10]);
                        echo $this->Form->control('preciomayor4',['label'=>'Precion unidad en pack 4']);
                        echo $this->Form->control('preciopack4')."</br>";

                        echo $this->Form->control('codigo',[
                            'value'=>$topproducto[0]['ultimoproducto']+1,
                            ]
                        );
                        echo $this->Form->control('codigopack');
                        echo $this->Form->control('cantpack',['value'=>6]);
                        echo $this->Form->control('stockminimo',['value'=>100]);
                        echo $this->Form->control('stock',['value'=>10]);
                  
                    $this->Form->unlockField('ganancia');
                     $this->Form->unlockField('precio');

                     $this->Form->unlockField('gananciapack');
                     $this->Form->unlockField('preciopack');
                     $this->Form->unlockField('preciopack_');
                     $this->Form->unlockField('preciopack0');
                     
                     $this->Form->unlockField('ganancia1');
                     $this->Form->unlockField('preciomayor1');
                     $this->Form->unlockField('preciopack1');

                     $this->Form->unlockField('ganancia2');
                     $this->Form->unlockField('preciomayor2');
                     $this->Form->unlockField('preciopack2');

                     $this->Form->unlockField('ganancia3');
                     $this->Form->unlockField('preciomayor3');
                     $this->Form->unlockField('preciopack3');

                     $this->Form->unlockField('ganancia4');
                     $this->Form->unlockField('preciomayor4');
                     $this->Form->unlockField('preciopack4');
                       ?>
                <?= $this->Form->end() ?>
                <?php

     ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" onclick='$("#formAgregarProducto").submit()'>Guardar Producto</button>
              </div>
        </div>
            <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

