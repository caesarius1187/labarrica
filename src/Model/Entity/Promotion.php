<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Promotion Entity
 *
 * @property int $id
 * @property int $producto_id
 * @property float $costo
 * @property float $ganancia
 * @property float $precio
 *
 * @property \App\Model\Entity\Producto $producto
 * @property \App\Model\Entity\Detallepromotion[] $detallepromotions
 */
class Promotion extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'producto_id' => true,
        'productopromocion_id' => true,
        'costo' => true,
        'ganancia' => true,
        'cantidad' => true,
        'precio' => true,
        'producto' => true,
        'detallepromotions' => true
    ];
}
