<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">created</th>
            <th scope="col">modified</th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= $this->Number->format($producto->id) ?></td>
            <td><?= h($producto->nombre) ?></td>
            <td><?= h($producto->created) ?></td>
            <td><?= h($producto->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $producto->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $producto->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $producto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $producto->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
