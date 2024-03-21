<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rubro Entity
 *
 * @property int $id
 * @property int $nombre
 * @property int $descripcion
 *
 * @property \App\Model\Entity\Producto[] $productos
 */
class Rubro extends Entity
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
        'nombre' => true,
        'descripcion' => true,
        'productos' => true
    ];
}
