<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Compra Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $fecha
 * @property float $neto
 * @property float $iva
 * @property float $total
 *
 * @property \App\Model\Entity\Detallecompra[] $detallecompras
 */
class Compra extends Entity
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
        'presupuesto' => true,
        'cliente_id' => true,
        'numero' => true,
        'puntodeventa_id' => true,
        'user_id' => true,
        'fecha' => true,
        'neto' => true,
        'porcentajedescuento' => true,
        'importedescuento' => true,
        'iva' => true,
        'total' => true,
        'created' => true,
        'modified' => true,
        'cliente' => true,
        'puntodeventa' => true,
        'user' => true  
    ];
}
