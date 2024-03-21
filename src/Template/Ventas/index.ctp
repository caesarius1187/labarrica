<?php
use Cake\Routing\Router;
use Cake\I18n\Time;
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
    $("#tblVentas").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
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
                                    'action' => 'addventa')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',                            
                        )
                    );
                    echo $this->Form->button(
                        'Detalle Ventas', 
                        array(
                            'onclick' => "window.location.href='".Router::url(
                                array(
                                    'controller' => 'ventas',
                                    'action' => 'listado')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',         
                            'style'=>'margin-right: 5px;width: 108px;margin-top: 0px;'                   
                        )
                    );
                    echo $this->Form->button(
                        'Ventas diarias', 
                        array(
                            'onclick' => "window.location.href='".Router::url(
                                array(
                                    'controller' => 'ventas',
                                    'action' => 'ventasdiarias')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',         
                            'style'=>'margin-right: 5px;width: 108px;margin-top: 0px;'                   
                        )
                    );
                    echo $this->Form->button(
                        'Ventas mensuales', 
                        array(
                            'onclick' => "window.location.href='".Router::url(
                                array(
                                    'controller' => 'ventas',
                                    'action' => 'ventasmensuales')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',         
                            'style'=>'margin-right: 5px;width: 128px;margin-top: 0px;'                   
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
                            <?php if(count($micaja)>0){
                                ?>
                                <h3 class="box-title">Punto de Venta ::</h3> 
                                <?php echo str_pad($micaja['puntodeventa']['numero'], 5, "0", STR_PAD_LEFT); 
                            }
                            ?>
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
                    <table cellpadding="10" cellspacing="10" id="tblVentas">
                        <thead>
                            <tr>
                                <th scope="col">Numero</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Creada</th>
                                <th scope="col" style="min-width:120px">Cliente</th>
                                <th scope="col">Punto de venta</th>
                                <th scope="col">Neto</th>
                                <th scope="col">Porcentaje descuento</th>
                                <th scope="col">Importe descuento</th>
                                <th scope="col">Total</th>
                                <th scope="col" class="actions"><?= __('Acciones') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><?= $this->Number->format($venta->numero) ?></td>                              
                                <td>
                                    <span style="display:none"><?= $venta->created->i18nFormat('YYYY-MM-dd HH:mm') ?></span>
                                    <?= $venta->created->i18nFormat('dd-MM-yyyy') ?></td>
                                <td><?= $venta->created->i18nFormat('HH:ss')?></td>
                                <td><?= $venta->has('cliente') ? $this->Html->link($venta->cliente->nombre, ['controller' => 'Clientes', 'action' => 'view', $venta->cliente->id]) : '' ?></td>
                                <td><?php 
                                    $numeroPDV = str_pad($venta->puntodeventa->numero, 5, "0", STR_PAD_LEFT);
                                    echo $this->Html->link( $numeroPDV, ['controller' => 'Puntodeventas', 'action' => 'view', $venta->puntodeventa->id]);
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
                                    echo $AuthUserTipo;
                                    echo $this->Form->postLink(
                                        $iconoTrash,
                                            ['action' => 'delete', $venta->id,], 
                                            [
                                                'confirm' => __('Esta seguro que desea eliminar la venta # {0}?', $venta->numero),
                                                'escape' => false,
                                            ],                                                
                                            ['class' =>'btn btn-app-select',]
                                        );
                                    $iconoCloud = '<i class="fa fa-cloud-upload"></i>';
                                    if(is_null($venta->comprobantedesde)){
                                        echo $this->Html->link($iconoCloud, [
                                                'action' => 'declararventa', $venta->id
                                            ],
                                            [
                                                'escape' => false,
                                            ]  
                                        ); 
                                    }
                                    ?>
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
