<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cliente[]|\Cake\Collection\CollectionInterface $clientes
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
echo $this->Html->script('clientes/index', ['block' => true]);
?>
<?php $this->start('scriptBottom'); ?>
<script>
 
</script>
<?php $this->end(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-app-selector2" data-toggle="modal" data-target="#modal-info" style="float: right;">
                        <i class="fa fa-user-plus"></i> 
                    </a>
                    <h3 class="box-title">Clientes/Provedores</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="pagos index large-9 medium-8 columns content">
                        <table cellpadding="0" cellspacing="0" id="tblClientes" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">nombre</th>
                                    <th scope="col">mail</th>
                                    <th scope="col">telefono</th>
                                    <th scope="col">celular</th>
                                    <th scope="col">direccion</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">CUIT</th>
                                    <th scope="col" class="actions"><?= __('Acciones') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= h($cliente->nombre) ?></td>
                                    <td><?= h($cliente->mail) ?></td>
                                    <td><?= h($cliente->telefono) ?></td>
                                    <td><?= h($cliente->celular) ?></td>
                                    <td><?= h($cliente->direccion) ?></td>
                                    <td><?= h($cliente->DNI) ?></td>
                                    <td><?= h($cliente->CUIT) ?></td>
                                    <td class="actions">
                                        <?php
                                        if(!$this->viewVars['userfiscal']){
                                            echo $this->Html->link(__('Ver'), ['action' => 'view', $cliente->id]);
                                        }
                                        ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $cliente->id]) ?>
                                        <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $cliente->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cliente->id)]) ?>
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
                echo $this->Form->create($micliente,[
                            'id' => "formAgregarCliente", 
                            'class'=>'form-control-horizontal',
                            'url'=>[                                
                                'controller'=>'Clientes',
                                'action'=>'add',
                            ]
                        ]);
                        echo $this->Form->control('nombre');
                        echo $this->Form->control('condicioniva',[
                            'options'=>[
                               1=>"IVA Responsable Inscripto",
                               4=>"IVA Sujeto Exento",
                               5=>"Consumidor Final",
                               6=>"Responsable Monotributo",
                               8=>"Proveedor del Exterior",
                               9=>"Cliente del Exterior",
                               10=>"IVA Liberado - Ley Nº 19.640",
                               11=>"IVA Responsable Inscripto - Agente de Percepción",
                               13=>"Monotributista Social",
                               15=>"IVA No Alcanzado",
                            ]
                        ]);
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