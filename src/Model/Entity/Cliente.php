<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cliente Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string $mail
 * @property string $telefono
 * @property string $celular
 * @property string $direccion
 * @property string $DNI
 * @property string $CUIT
 *
 * @property \App\Model\Entity\Venta[] $ventas
 */
class Cliente extends Entity
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
        'mail' => true,
        'condicioniva' => true,
        'telefono' => true,
        'celular' => true,
        'direccion' => true,
        'DNI' => true,
        'CUIT' => true,
        'ventas' => true
    ];
}
