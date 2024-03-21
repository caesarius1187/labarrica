<?php
//QUERY para actualizar precios de prductos
//update productos set productos.precio = (1+(ganancia/100))*costo
//update productos set productos.preciopack = (1+(gananciapack/100))*costo
//UPDATE productos SET productos.codigo = REPLACE (productos.codigo, ' ', '')
//UPDATE productos SET productos.codigo = REPLACE (productos.codigo, ',', '')
//echo $this->Html->script('jquery.dataTables.js',array('inline'=>false));

use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto[]|\Cake\Collection\CollectionInterface $productos
 */
echo $this->Html->script('table2excel',array('inline'=>false));

$this->Html->css([
    'AdminLTE./plugins/datatables/dataTables.bootstrap',
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./plugins/datatables/jquery.dataTables.min',
  'AdminLTE./plugins/datatables/dataTables.bootstrap.min',
],
['block' => 'script']);
?>

<?php $this->start('scriptBottom'); ?>
<script>
  $(function () {
    var table = $("#tblProductos").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
    $( "#clickExcel" ).click(function() {
        setTimeout(
            function() 
            {
               var table2excel = new Table2Excel();
                table2excel.export(document.querySelectorAll(".toExcelTable"));
            }, 2000
        );
        
    });
    CatchFormProducto();
    $('#ganancia').change(function(){
        calcularProducto();
    });
    $('#gananciapack').change(function(){
        calcularProducto();
    });
    $('#ganancia1').change(function(){
        calcularProducto();
    });
    $('#ganancia2').change(function(){
        calcularProducto();
    });
    $('#ganancia3').change(function(){
        calcularProducto();
    });
    $('#ganancia4').change(function(){
        calcularProducto();
    });
    $('#costo').change(function(){
        calcularProducto();
    });
    $('#cantpack').change(function(){
        calcularProducto();
    });
    catchPreciosChange();
    calcularProducto();
  });
    function CatchFormProducto(){
        $('#formAgregarProducto').submit(function(){
            var formData = $(this).serialize();
            var formUrl = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
                    location.reload();
                },
                error: function(xhr,textStatus,error){
                    callAlertPopint(textStatus);
                }
            });
            return false;
        });
    }
    function calcularGanancia(ganancia,precio,preciopack,costo){
        var precio = $('#'+precio).val();
        var costo = $('#'+costo).val();
        var porcentaje = precio/costo;
        porcentaje -= 1;
        porcentaje = porcentaje*100;
        $('#'+ganancia).val((porcentaje).toFixed(2));
         if(preciopack!=''){
            var cantidad = $("#cantpack").val();
            var preciopackcalculado = cantidad*precio;
            $('#'+preciopack).val((preciopackcalculado).toFixed(2));
        }
     }
    function calcularPrecioUnidad(ganancia,precio,preciopack,costo){
        var preciopack = $('#'+preciopack).val();
        var cantidadPack = $('#cantpack').val();
        var preciocalculado = preciopack/cantidadPack;
        var costo = $('#'+costo).val();
        var porcentaje = preciocalculado/costo;
        porcentaje -= 1;
        porcentaje = porcentaje*100;
        $('#'+ganancia).val((porcentaje).toFixed(2));
        $('#'+precio).val((preciocalculado).toFixed(2));
     }
    function catchPreciosChange(){
        $('#precio').change(
           function(){
              calcularGanancia('ganancia','precio','','costo');
        });
        $('#preciopack').change(
           function(){
              calcularGanancia('gananciapack','preciopack','preciopack0','costo');
        });
        $('#preciomayor1').change(
           function(){
              calcularGanancia('ganancia1','preciomayor1','preciopack1','costo');
        });
        $('#preciomayor2').change(
           function(){
              calcularGanancia('ganancia2','preciomayor2','preciopack2','costo');
        });
        $('#preciomayor3').change(
           function(){
              calcularGanancia('ganancia3','preciomayor3','preciopack3','costo');
        });
        $('#preciomayor4').change(
           function(){
              calcularGanancia('ganancia4','preciomayor4','preciopack4','costo');
        });                
        $('#preciopack0').change(
            function(){
               calcularPrecioUnidad('gananciapack','preciopack','preciopack0','costo')
           }
        );
        $('#preciopack1').change(
            function(){
               calcularPrecioUnidad('ganancia1','preciomayor1','preciopack1','costo')
           }
        );
        $('#preciopack2').change(
            function(){
               calcularPrecioUnidad('ganancia2','preciomayor2','preciopack2','costo')
           }
        );
        $('#preciopack3').change(
            function(){
               calcularPrecioUnidad('ganancia3','preciomayor3','preciopack3','costo')
           }
        );
        $('#preciopack4').change(
            function(){
               calcularPrecioUnidad('ganancia4','preciomayor4','preciopack4','costo')
           }
        );
    }
    function calcularProducto(){
        var costo = $('#costo').val();
        var ganancia = $('#ganancia').val();
        var cantidad = $('#cantpack').val();
        var precio = costo*(1+(ganancia/100));
        $('#precio').val(precio.toFixed(2));
        var gananciapack = $('#gananciapack').val();
        var preciopack = costo*(1+(gananciapack/100));
        var preciopackcalculado = preciopack*cantidad;
        $('#preciopack').val(preciopack.toFixed(2));
        $('#preciopack0').val(preciopackcalculado.toFixed(2));

        var ganancia1 = $('#ganancia1').val();
        var preciopack1 = costo*(1+(ganancia1/100));
        $('#preciomayor1').val(preciopack1.toFixed(2));
        preciopackcalculado = preciopack1*cantidad;
        $('#preciopack1').val(preciopackcalculado.toFixed(2));

         var ganancia2 = $('#ganancia2').val();
        var preciopack2 = costo*(1+(ganancia2/100));
        $('#preciomayor2').val(preciopack2.toFixed(2));
        preciopackcalculado = preciopack2*cantidad;
        $('#preciopack2').val(preciopackcalculado.toFixed(2));

         var ganancia3 = $('#ganancia3').val();
        var preciopack3 = costo*(1+(ganancia3/100));
        $('#preciomayor3').val(preciopack3.toFixed(2));
        preciopackcalculado = preciopack3*cantidad;
        $('#preciopack3').val(preciopackcalculado.toFixed(2));

         var ganancia4 = $('#ganancia4').val();
        var preciopack4 = costo*(1+(ganancia4/100));
        $('#preciomayor4').val(preciopack4.toFixed(2));
        preciopackcalculado = preciopack4*cantidad;
        $('#preciopack4').val(preciopackcalculado.toFixed(2));
    }
</script>

<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Productos</h3>
                    <?php

                    echo $this->Form->button(
                        'Actualizar Precio por rubro', 
                        array(
                            'onclick' => "window.location.href='".Router::url(
                                array('controller' => 'productos','action' => 'actualizarxrubro')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',
                            'style'=>'margin-top: 5px;margin-right: 5px;;width: 184px;'                            
                        )
                    ); 
                    if(!$this->viewVars['userfiscal']){
                        echo $this->Form->button(
                            'Resumen', 
                            array(
                                'onclick' => "window.location.href='".Router::url(
                                    array('controller' => 'productos','action' => 'resumen')
                                 )."'",
                                'class'=>'btn btn-block btn-primary btn-flat btn-add',
                                'style'=>'margin-top: 5px;margin-right: 5px;margin-left: 5px;width: 81px;'                            
                            )
                        ); 
                    }
                    echo $this->Form->button(
                            'Importar', 
                            array(
                                'onclick' => "window.location.href='".Router::url(
                                    array('controller' => 'productos','action' => 'importar')
                                 )."'",
                                'class'=>'btn btn-block btn-primary btn-flat btn-add',
                                'style'=>'margin-top: 5px;margin-right: 5px;margin-left: 5px;width: 81px;'                            
                            )
                        ); 
                     ?>
                     <a class="btn btn-app-selector2" data-toggle="modal" data-target="#modal-primary" style="float: right;margin: 5px 0px 0px 0px;">
                                    <i class="fa fa-plus"></i> 
                                </a> 
                    <?php                  
                     echo $this->Form->button('Excel',
                                array('type' => 'button',
                                    'id'=>"clickExcel",
                                    'class' =>"btn btn-success btn_imprimir ",
                                    'style'=>'vertical-align: bottom;'
                                )
                            );
                    ?>                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="productos index large-9 medium-8 columns content">
                    <table cellpadding="0" cellspacing="0" id="tblProductos" class="toExcelTable">
                        <thead>
                            <tr>
                                <th scope="col">Rubro</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Costo</th>
                                <th scope="col">Pre.</th>
                                <th scope="col">%G1.</th>
                                <th scope="col">Pre2</th>
                                <th scope="col">%G2.</th>
                                <th scope="col">Cod.</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Mod.</th>
                                <th scope="col" class="actions"><?= __('Act.') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto):    
                                $trwitherror = false;
                                $title="";
                                $precioCalculado = round($producto->costo*(1+$producto->ganancia/100), 2);
                                $precioCalculadoPack = round($producto->costo*(1+$producto->gananciapack), 2);
                                $diferencia = $precioCalculado*1 - $producto->precio*1;
                                if($diferencia<-0.01 || $diferencia>0.01){
                                    $trwitherror = true;
                                    $title="Error en el calculo del precio del producto editelo. ".$precioCalculado."!=".$producto->precio;
                                }
                                $diferencia2 = $precioCalculadoPack*1 - $producto->preciopack*1;
                                if($diferencia2<-0.01 || $diferencia2>0.01){
                                    $trwitherror = true;
                                    $title="Error en el calculo del precio del pack producto editelo. ".$precioCalculadoPack."!=".$producto->preciopack;
                                }
                                $precBgr = 'inherit';
                                if($trwitherror){
                                    $precBgr = 'orange';      
                                }
                                ?>
                            <tr >
                                <td ><label style="width: 100px;" class="tdTruncated"><?= $producto->rubro->nombre ?><label></td>                               
                                <td>
                                    <label title="<?= $producto->nombre ?>" style="width: 225px;" class="tdTruncated"><?= $producto->nombre ?></label>
                                </td>
                                <td><?= $this->Number->format($producto->costo) ?></td>
                                <td title="<?php echo $title ?>" style="background-color: <?= $precBgr ?>"><?= $this->Number->format($producto->precio) ?></td>
                                <td><?php echo $producto->ganancia ?></td>
                                <td title="<?php echo $title ?>" style="background-color: <?= $precBgr ?>"><?= $this->Number->format($producto->preciopack0) ?></td>
                                <td><?php echo $producto->gananciapack ?></td>
                                <td>
                                    <label title="<?= $producto->codigo ?>" style="width: 60px;" class="tdTruncatedLeft"><?= $producto->codigo ?></label>
                                </td>
                                
                                <?php 
                                $color = 'inherit';
                                if($producto->stockminimo>=$producto->stock){
                                    $color = 'red';
                                }
                                ?>
                                <td style="background-color: <?= $color ?>"><?= $this->Number->format($producto->stock) ?></td>
                                <td><?php
                                     if($producto->modified!=''){
                                        echo $producto->modified->i18nFormat('yyyy-MM-dd HH:mm');
                                     }
                                     ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $producto->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $producto->id], ['target' => '_blank']) ?>
                                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $producto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $producto->id)]) ?>
                                </td>
                            </tr>
                            <?php 
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
                echo $this->Form->create($miproducto,[
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
                            'value'=>$topproducto+1,
                            ]
                        );
                        echo $this->Form->control('codigopack',[
                            'value'=>($topproducto+1)*1000,
                            ]);
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


<?php
function unlockfields($context){
     $context->Form->unlockField('ganancia');
     $context->Form->unlockField('precio');

     $context->Form->unlockField('gananciapack');
     $context->Form->unlockField('preciopack');
     $context->Form->unlockField('preciopack0');
     $context->Form->unlockField('ganancia1');
     $context->Form->unlockField('preciomayor1');
     $context->Form->unlockField('preciopack1');

     $context->Form->unlockField('ganancia2');
     $context->Form->unlockField('preciomayor2');
     $context->Form->unlockField('preciopack2');

     $context->Form->unlockField('ganancia3');
     $context->Form->unlockField('preciomayor3');
     $context->Form->unlockField('preciopack3');

     $context->Form->unlockField('ganancia4');
     $context->Form->unlockField('preciomayor4');
     $context->Form->unlockField('preciopack4');
}
?>