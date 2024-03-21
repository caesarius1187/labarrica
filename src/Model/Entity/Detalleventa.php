<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Detalleventa Entity
 *
 * @property int $id
 * @property int $producto_id
 * @property float $precio
 * @property int $cantidad
 * @property float $porcentajedescuento
 * @property float $importedescuento
 * @property float $subtotal
 *
 * @property \App\Model\Entity\Producto $producto
 */
class Detalleventa extends Entity
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
        'precio' => true,
        'cantidad' => true,
        'porcentajedescuento' => true,
        'tipoprecio' => true,
        'importedescuento' => true,
        'codigoalicuota' => true,
        'alicuota' => true,
        'subtotal' => true,
        'producto' => true,
        'costo' => true,
        'ganancia' => true,
        'importeiva' => true,
        'subtotalconiva' => true,
        'fprecio' => true,
        'fsubtotalconiva' => true,
        'fimporteiva' => true,
        'falicuota' => true,
        'fcantidad' => true,
        'fporcentajedescuento' => true,
        'fimportedescuento' => true,
        'fsubtotal' => true,
        'fcodigoalicuota' => true,
    ];
}
