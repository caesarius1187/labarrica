<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto[]|\Cake\Collection\CollectionInterface $productos
 */
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
    $("#tblProductos").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
  });
</script>
<script>
    $('document').ready(function(){
        
    });
</script>
<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Promociones</h3>
                    <?php                 
                    echo $this->Form->button(
                        'Agregar', 
                        array(
                            'onclick' => "window.location.href='".Router::url(
                                array('controller' => 'promotions','action' => 'add')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',                            
                        )
                    );
                     echo $this->Form->button(
                            'Importar', 
                            array(
                                'onclick' => "window.location.href='".Router::url(
                                    array('controller' => 'promotions','action' => 'importar')
                                 )."'",
                                'class'=>'btn btn-block btn-primary btn-flat btn-add',
                                'style'=>'margin-top: 0px;margin-right: 5px;margin-left: 5px;width: 81px;'                            
                            )
                        ); 
                     echo $this->Form->button(
                            'Resumen', 
                            array(
                                'onclick' => "window.location.href='".Router::url(
                                    array('controller' => 'promotions','action' => 'resumenpromociones')
                                 )."'",
                                'class'=>'btn btn-block btn-primary btn-flat btn-add',
                                'style'=>'margin-top: 0px;margin-right: 5px;margin-left: 5px;width: 81px;'                            
                            )
                        ); 
                    ?>                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="productos index large-9 medium-8 columns content">
                    <table cellpadding="0" cellspacing="0" id="tblProductos">
                        <thead>
                            <tr>
                                <th scope="col">Rubro</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Costo</th>
                                <th scope="col">Ganancia(Prom)</th>
                                <th scope="col">Precio</th>
                                <th scope="col" class="actions"><?= __('Acciones') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto):    
                                $trwitherror = false;
                                $title="";
                                $precioCalculado = round($producto->costo*(1+$producto->ganancia/100), 2);
                                $precioCalculadoPack = round($producto->costo*(1+$producto->gananciapack), 2);

                                if($precioCalculado!=$producto->precio){
                                    //$trwitherror = true;
                                    $title="Error en el calculo del precio del producto editelo. ".$precioCalculado."!=".$producto->precio;
                                }
                                if($precioCalculadoPack!=$producto->preciopack){
                                    //$trwitherror = true;
                                    $title="Error en el calculo del precio del pack producto editelo. ".$precioCalculadoPack."!=".$producto->preciopack;
                                }
                                ?>
                            <tr class="<?php echo $trwitherror?"trwitherror":"" ?>" title="<?php echo $title ?>">
                                <td><?= $producto->has('rubro') ? $this->Html->link($producto->rubro->nombre, ['controller' => 'Rubros', 'action' => 'view', $producto->rubro->id]) : '' ?></td>                               
                                <td><?php echo $producto->nombre ?></td>
                                <td><?= $this->Number->format($producto->costo) ?></td>
                                <td><?php 
                                    $ganancia = 0;
                                    foreach ($producto->promotions as $kpp => $promoProd) {
                                        $ganancia += $promoProd->ganancia;
                                    }
                                    $gannaciaprom = $ganancia / count($producto->promotions) / 100;
                                    echo number_format($gannaciaprom,2,',','.')."%";
                                ?></td>
                                <td><?= $this->Number->format($producto->precio) ?></td>
                                
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $producto->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $producto->id]) ?>
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

