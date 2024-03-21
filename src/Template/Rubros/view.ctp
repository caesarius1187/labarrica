<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rubro $rubro
 */
?>
<div class="rubros view large-9 medium-8 columns content">
    <h3><?= h($rubro->nombre) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?php echo $rubro->descripcion ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Productos Relacionados') ?></h4>
        <?php if (!empty($rubro->productos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col"><?= __('Precio') ?></th>
                <th scope="col"><?= __('Costo') ?></th>
                <th scope="col"><?= __('Ganancia') ?></th>
                <th scope="col"><?= __('Gananciapack') ?></th>
                <th scope="col"><?= __('Preciopack') ?></th>
                <th scope="col"><?= __('Codigo') ?></th>
                <th scope="col"><?= __('Codigopack') ?></th>
                <th scope="col"><?= __('Cantpack') ?></th>
                <th scope="col"><?= __('Stockminimo') ?></th>
                <th scope="col"><?= __('Stock') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($rubro->productos as $productos): ?>
            <tr>
                <td><?= h($productos->nombre) ?></td>
                <td><?= h($productos->precio) ?></td>
                <td><?= h($productos->costo) ?></td>
                <td><?= h($productos->ganancia) ?></td>
                <td><?= h($productos->gananciapack) ?></td>
                <td><?= h($productos->preciopack) ?></td>
                <td><?= h($productos->codigo) ?></td>
                <td><?= h($productos->codigopack) ?></td>
                <td><?= h($productos->cantpack) ?></td>
                <td><?= h($productos->stockminimo) ?></td>
                <td><?= h($productos->stock) ?></td>
                <td><?= h($productos->created) ?></td>
                <td><?= h($productos->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Productos', 'action' => 'view', $productos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Productos', 'action' => 'edit', $productos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Productos', 'action' => 'delete', $productos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
