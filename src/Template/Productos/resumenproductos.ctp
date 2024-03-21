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
?>
<?php $this->start('scriptBottom'); ?>
<script>
  $(function () {
    $( "#clickExcel" ).click(function() {
        setTimeout(
            function() 
            {
               var table2excel = new Table2Excel();
                table2excel.export(document.querySelectorAll(".toExcelTable"));
            }, 2000
        );
        
    });
    
  });
</script>

<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Productos</h3>
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
                                <td ><?= $producto->rubro->nombre ?></td>                               
                                <td>
                                    <?= $producto->nombre ?>
                                </td>
                                <td><?= number_format($producto->costo,2,'.','') ?></td>
                                <td><?= number_format($producto->precio,2,'.','') ?></td>
                                <td><?php echo $producto->ganancia ?></td>
                                <td><?= number_format($producto->preciopack0,2,'.','') ?></td>
                                <td><?php echo $producto->gananciapack ?></td>
                                <td><?php echo $producto->ganancia1 ?></td>
                                <td><?php echo $producto->ganancia2 ?></td>
                                <td><?php echo $producto->ganancia3 ?></td>
                                <td><?php echo $producto->ganancia4 ?></td>
                                <td><?php echo $producto->preciopack ?></td>
                                <td><?php echo $producto->preciomayor1 ?></td>
                                <td><?php echo $producto->preciomayor2 ?></td>
                                <td><?php echo $producto->preciomayor3 ?></td>
                                <td><?php echo $producto->preciomayor4 ?></td>
                                <td><?php echo $producto->preciopack1 ?></td>
                                <td><?php echo $producto->preciopack2 ?></td>
                                <td><?php echo $producto->preciopack3 ?></td>
                                <td><?php echo $producto->preciopack4 ?></td>
                                <td><?php echo $producto->codigopack ?></td>
                                <td><?php echo $producto->cantpack ?></td>
                                <td><?php echo $producto->stockminimo ?></td>
                                <td><?php echo $producto->disabled ?></td>
                                <td>
                                    <?= $producto->codigo ?>
                                </td>
                                <td><?= number_format($producto->stock,2,'.','') ?></td>
                                <td><?php
                                     if($producto->modified!=''){
                                        echo $producto->modified->i18nFormat('yyyy-MM-dd HH:mm');
                                     }
                                     ?></td>
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
