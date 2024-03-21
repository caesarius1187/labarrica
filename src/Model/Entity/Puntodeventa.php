<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Puntodeventa Entity
 *
 * @property int $id
 * @property int $numero
 * @property string $nombre
 * @property string $descripcion
 *
 * @property \App\Model\Entity\Venta[] $ventas
 */
class Puntodeventa extends Entity
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
        'numero' => true,
        'nombre' => true,
        'descripcion' => true,
        'ventas' => true,
        'facturacionhabilitada' => true
    ];
}
