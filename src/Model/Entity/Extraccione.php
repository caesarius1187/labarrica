<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Extraccione Entity
 *
 * @property int $id
 * @property string $descripcion
 * @property float $importe
 * @property float $saldo
 * @property \Cake\I18n\FrozenTime $fecha
 */
class Extraccione extends Entity
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
        'puntodeventa_id' => true,
        'user_id' => true,
        'descripcion' => true,
        'importe' => true,
        'saldo' => true,
        'fecha' => true
    ];
}
