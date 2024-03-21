<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puntodeventa[]|\Cake\Collection\CollectionInterface $puntodeventas
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
    $("#tblPuntodeventas").DataTable({
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
                    <h3 class="box-title">Puntodeventas</h3>
                    <?php
                    echo $this->Form->button(
                        'Agregar', 
                        array(
                            'onclick' => "window.location.href='".Router::url(
                                array('controller' => 'puntodeventas','action' => 'add')
                             )."'",
                            'class'=>'btn btn-block btn-primary btn-flat btn-add',                            
                        )
                    );

                    ?>                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="puntodeventas index large-9 medium-8 columns content">
                    <table cellpadding="0" cellspacing="0" id="tblPuntodeventas">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Desripcion</th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($puntodeventas as $puntodeventa):?>
                            <tr>
                                <td><?php echo $puntodeventa->nombre ?></td>
                                <td><?php echo $puntodeventa->descripcion ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $puntodeventa->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $puntodeventa->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $puntodeventa->id], ['confirm' => __('Are you sure you want to delete # {0}?', $puntodeventa->id)]) ?>
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
