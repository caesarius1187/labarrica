<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rubro[]|\Cake\Collection\CollectionInterface $rubros
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
    $("#tblRubros").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });
  });
</script>
<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Rubros</h3>
                    <?php
                    if(!$this->viewVars['userfiscal']){
                        echo $this->Form->button(
                            'Resumen', 
                            array(
                                'onclick' => "window.location.href='".Router::url(
                                    array('controller' => 'rubros','action' => 'resumen')
                                 )."'",
                                'class'=>'btn btn-block btn-primary btn-flat btn-add',
                                'style'=>'margin-top: 5px;margin-right: 90px;margin-left: 5px;width: 81px;'                            
                            )
                        ); 
                    }
                    echo $this->Form->button(
                        'Agregar', 
                        array(
                            'onclick' => "window.location.href='".Router::url(
                                array('controller' => 'rubros','action' => 'add')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',                            
                        )
                    );

                    ?>                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="rubros index large-9 medium-8 columns content">
                    <table cellpadding="0" cellspacing="0" id="tblRubros">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Desripcion</th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rubros as $rubro):?>
                            <tr>
                                <td><?php echo $rubro->nombre ?></td>
                                <td><?php echo $rubro->descripcion ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $rubro->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rubro->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rubro->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rubro->id)]) ?>
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

