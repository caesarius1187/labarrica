<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Caja Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $puntodeventas_id
 * @property \Cake\I18n\FrozenTime $apertura
 * @property float $importeapertura
 * @property \Cake\I18n\FrozenTime $cierre
 * @property float $importecierre
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Puntodeventa $puntodeventa
 */
class Caja extends Entity
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
        'user_id' => true,
        'controlada' => true,
        'puntodeventa_id' => true,
        'apertura' => true,
        'importeapertura' => true,
        'cierre' => true,
        'importecierre' => true,
        'user' => true,
        'puntodeventa' => true,
        'descripcionapertura' => true,
        'descripcioncierre' => true,
    ];
}
