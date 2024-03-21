<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pago $pago
 */
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Movimiento</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="productos index large-9 medium-8 columns content">
                        <table class="vertical-table">
                             <tr>
                                <th scope="row"><?= __('Usuario') ?></th>
                                <td><?= $this->Html->link($pago->user->username, ['controller' => 'Users', 'action' => 'view', $pago->user->id])  ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Cliente') ?></th>
                                <td><?= $pago->has('cliente') ? $this->Html->link($pago->cliente->nombre, ['controller' => 'Clientes', 'action' => 'view', $pago->cliente->id]) : '' ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Descripcion') ?></th>
                                <td><?= h($pago->descripcion) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Importe') ?></th>
                                <td><?= $this->Number->format($pago->importe) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Fecha') ?></th>
                                <td><?= h($pago->fecha) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Creado') ?></th>
                                <td><?= h($pago->created) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Modificado') ?></th>
                                <td><?= h($pago->modified) ?></td>
                            </tr>
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
