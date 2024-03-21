<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Promotion $promotion
 */
?>

<div class="promotions view large-9 medium-8 columns content">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Promocion') ?></th>
            <td><?= $producto->FullName ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Costo') ?></th>
            <td><?= $this->Number->format($producto->costo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ganancia') ?></th>
            <td><?= $this->Number->format($producto->ganancia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Precio') ?></th>
            <td><?= $this->Number->format($producto->precio) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Productos de la promo') ?></h4>
        <?php if (!empty($producto->promotions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Producto') ?></th>
                <th scope="col"><?= __('Cantidad') ?></th>
                <th scope="col"><?= __('Costo') ?></th>
                <th scope="col"><?= __('Ganancia') ?></th>
                <th scope="col"><?= __('Precio') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($producto->promotions as $promotion): ?>
            <tr>
                <td><?= $promotion->has('producto') ? $this->Html->link($promotion->producto->FullName, ['controller' => 'Productos', 'action' => 'view', $promotion->producto->id]) : '' ?></td>
                <td><?= $this->Number->format($promotion->cantidad) ?></td>
                <td><?= $this->Number->format($promotion->costo) ?></td>
                <td><?= $this->Number->format($promotion->ganancia) ?></td>
                <td><?= $this->Number->format($promotion->precio) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
