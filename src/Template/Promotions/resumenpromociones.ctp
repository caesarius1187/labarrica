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
                    <h3 class="box-title">Promociones</h3>
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
                                <th scope="col">NombrePromocion</th>
                                <th scope="col">CodigoPromocion</th>
                                <th scope="col">NombreIngrediente</th>
                                <th scope="col">CodigoIngrediente</th>
                                <th scope="col">Costo</th>
                                <th scope="col">Ganancia.</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($promotions as $promotion):  
                                ?>
                            <tr >
                                <td><?= $promotion->productospromocion->nombre ?></td>                               
                                <td><?= $promotion->productospromocion->codigo ?></td>           
                                <td><?= $promotion->producto->nombre ?></td>                               
                                <td><?= $promotion->producto->codigo ?></td>                               
                                <td><?= $promotion->costo ?></td>
                                <td><?= $promotion->ganancia ?></td>
                                <td><?= $promotion->precio ?></td>
                                <td><?= $promotion->cantidad ?></td>
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
