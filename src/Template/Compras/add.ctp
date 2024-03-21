<?php
use Cake\Routing\Router;

echo $this->Form->control('cantDetalle', [
    'type' => 'hidden', 
    'value' => 0, 
]);  
echo $this->Form->control('allproductos', [
    'value' => "", 
    'type'=>'hidden'
    ]);


echo $this->Html->script('compras/add', ['block' => true]);
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
echo $this->Form->input('cantDetalle', [
    'type' => 'hidden', 
    'value' => 0, 
]);  
echo $this->Form->input('productoslista', [
    'type' => 'select', 
    'label' => false, 
    'style' => 'display:none', 
    'options' => $productos, 
]);  
echo $this->Form->input('urlBuild', [
    'type' => 'hidden', 
    'value' => $this->Url->build( [ 'controller' => 'Productos', 'action' => 'search' ] ), 
]);  
echo $this->Form->input('urlBuildAutocomplete', [
    'type' => 'hidden', 
    'value' => $this->Url->build( [ 'controller' => 'Productos', 'action' => 'autoComplete' ] ), 
]);  
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
                <?php echo $this->Form->create($compra,[
                            'id' => "formAgregarCompra", 
                            'class'=>'form-control-horizontal',
                            'action'=>'add'
                        ]);?>

                <div class="box-header">
                     <?php 
                     $nuemeroUltimacompra = $ultimacompra[0]['ultimacompra']*1+1;
                     ?>
                    <h3 class="box-title">Agregar una Compra ::</h3> <?= __('Usuario '.$AuthUserNombre) ?>                    
                </div>
                <!-- /.box-header -->
                <div class="box-body col-xs-8">
                    <div class="compras index large-9 medium-8 columns content">
                        <fieldset id="fsDetalles">
                            <legend><?= __('Detalle de compra') ?></legend>
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
                    <div class="compras index large-9 medium-8 columns content">
                            <?php
                                //si es presupuesto o no        
                                echo $this->Form->control('id', [
                                    'type' => 'hidden', 
                                ]);     
                                echo $this->Form->control('comprobante_id', [
                                    'options' => $comprobantes, 
                                    'style' => 'width:250px', 
                                    'label' => 'Comprobante', 
                                    'empty' => false]);      
                                echo $this->Form->control('numero',[
                                    'value'=>0,
                                    'label'=>[
                                        'text'=>'N Compra',
                                        'style'=>'margin: 10px;'
                                    ],
                                ])."</br>";
                                echo $this->Form->control('cliente_id', [
                                    'options' => $clientes, 
                                    'style' => 'width:250px', 
                                    'label' => 'Provedor', 
                                    'default' => 1,                                     
                                    'empty' => false]);
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
                                echo $this->Form->control('presupuesto',['type'=>'hidden']);         
                                //echo $this->Form->control('cobrado');         
                                echo "</br>";
                                //esta tiene que ser de la caja que tiene abierta este usuario
                               
                                echo $this->Form->control('puntodeventa_id', [
                                    'value' => $micaja['puntodeventa_id'], 
                                    'type' => 'hidden', 
                                    'empty' => false]);
                                echo $this->Form->control('user_id', [
                                    'value' => $AuthUserId, 
                                    'type' => 'hidden'
                                ]);                              
                               
                                echo $this->Form->control('neto',['readonly','readonly']);
                                echo $this->Form->control('porcentajedescuento',[
                                    'label'=>'% Desc',
                                    'onchange' => 'agregarDetalle();', 
                                ])."</br>";
                                echo $this->Form->control('importedescuento',[
                                    'readonly',
                                    'label'=>[
                                        'text'=>'Total a Descontar: $0',
                                        'style'=>'margin: 10px;'
                                    ],
                                    'style'=>'display:none',
                                    'templates' => [
                                        'inputContainer' => '<div class="form-group input {{type}}{{required}}" style="border:1px dotted black">{{content}}</div>',
                                    ],                                    
                                ]);
                                echo $this->Form->control('iva',['type'=>'hidden']);
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
                                ?>                                                
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
        $context->Form->unlockField('detallecompras.'.$i.'.id');
        $context->Form->unlockField('detallecompras.'.$i.'.producto_id');
        $context->Form->unlockField('detallecompras.'.$i.'.compra_id');
        $context->Form->unlockField('detallecompras.'.$i.'.precio');
        $context->Form->unlockField('detallecompras.'.$i.'.ganancia');
        $context->Form->unlockField('detallecompras.'.$i.'.costo');
        $context->Form->unlockField('detallecompras.'.$i.'.cantidad');
        $context->Form->unlockField('detallecompras.'.$i.'.porcentajedescuento');
        $context->Form->unlockField('detallecompras.'.$i.'.importedescuento');
        $context->Form->unlockField('detallecompras.'.$i.'.subtotal');
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
                        echo $this->Form->control('ganancia',['value'=>15]);
                        echo $this->Form->control('precio')."</br>";
                        echo $this->Form->control('gananciapack',['value'=>10]);
                        echo $this->Form->control('preciopack')."</br>";
                        echo $this->Form->control('codigo');
                        echo $this->Form->control('codigopack');
                        echo $this->Form->control('cantpack',['value'=>6]);
                        echo $this->Form->control('stockminimo',['value'=>100]);
                        echo $this->Form->control('stock',['value'=>10]);
                    ?>
                <?= $this->Form->end() ?>
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
