<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto $producto
 */
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= h($producto->nombre) ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="productos index large-9 medium-8 columns content">
                        <table class="vertical-table">
                            <tr>
                                <th scope="row"><?= __('Marca y Modelo') ?></th>
                                <?php 
                                $marcamodelo = "";
                                if($producto->has('modelo')){
                                    $marcamodelo.= $producto->modelo->marca->nombre."-".$producto->modelo->nombre;
                                }
                                ?>
                                <td><?= $marcamodelo ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Rubro') ?></th>
                                <td><?= $producto->has('rubro') ? $this->Html->link($producto->rubro->nombre, ['controller' => 'Rubros', 'action' => 'view', $producto->rubro->id]) : '' ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Codigo') ?></th>
                                <td><?= h($producto->codigo) ?></td>
                                <th scope="row"><?= __('Codigopack') ?></th>
                                <td><?= h($producto->codigopack) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Costo') ?></th>
                                <td><?= $this->Number->format($producto->costo) ?></td>
                                <th scope="row"><?= __('Ganancia') ?></th>
                                <td>% <?= $this->Number->format($producto->ganancia) ?></td>
                                <th scope="row"><?= __('Precio') ?></th>
                                <td>$ <?= $this->Number->format($producto->precio) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Gananciapack') ?></th>
                                <td>% <?= $this->Number->format($producto->gananciapack) ?></td>
                                <th scope="row"><?= __('Preciopack') ?></th>
                                <td> $<?= $this->Number->format($producto->preciopack) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Ganancia1') ?></th>
                                <td>% <?= $this->Number->format($producto->ganancia1) ?></td>
                                <th scope="row"><?= __('Precio1') ?></th>
                                <td> $<?= $this->Number->format($producto->preciomayor1) ?></td>
                                <th scope="row"><?= __('Ganancia2') ?></th>
                                <td>% <?= $this->Number->format($producto->ganancia2) ?></td>
                                <th scope="row"><?= __('Precio2') ?></th>
                                <td> $<?= $this->Number->format($producto->preciomayor2) ?></td>
                            </tr>
                             <tr>
                                <th scope="row"><?= __('Ganancia3') ?></th>
                                <td>% <?= $this->Number->format($producto->ganancia3) ?></td>
                                <th scope="row"><?= __('Precio3') ?></th>
                                <td> $<?= $this->Number->format($producto->preciomayor3) ?></td>
                                <th scope="row"><?= __('Ganancia4') ?></th>
                                <td>% <?= $this->Number->format($producto->ganancia4) ?></td>
                                <th scope="row"><?= __('Precio4') ?></th>
                                <td> $<?= $this->Number->format($producto->preciomayor4) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Cantpack') ?></th>
                                <td><?= $this->Number->format($producto->cantpack) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Stockminimo') ?></th>
                                <td><?= $this->Number->format($producto->stockminimo) ?></td>
                                <th scope="row"><?= __('Stock') ?></th>
                                <td><?= $this->Number->format($producto->stock) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= __('Creado') ?></th>
                                <td><?= h($producto->created) ?></td>
                                <th scope="row"><?= __('Modificado') ?></th>
                                <td><?= h($producto->modified) ?></td>
                            </tr>
                        </table>
                        <div class="related">
                            <h4><?= __('Stock ') ?></h4>
                            <?php if (!empty($producto->detalleproductos)): ?>
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <th scope="col"><?= __('Deposito') ?></th>
                                    <th scope="col"><?= __('Cantidad') ?></th>
                                    <th scope="col"><?= __('Vencimiento') ?></th>
                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                </tr>
                                <?php foreach ($producto->detalleproductos as $detalleproducto): ?>
                                <tr>
                                    <td><?= h($detalleproducto->deposito->nombre) ?></td>
                                    <td><?= h($detalleproducto->stock) ?></td>
                                    <td><?= h($detalleproducto->vencimiento) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Detalleproductos', 'action' => 'view', $detalleproducto->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Detalleproductos', 'action' => 'edit', $detalleproducto->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Detalleproductos', 'action' => 'delete', $detalleproducto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detalleproducto->id)]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php endif; ?>
                        </div>                       
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
