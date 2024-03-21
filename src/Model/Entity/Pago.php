<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pago Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property \Cake\I18n\FrozenDate $fecha
 * @property float $importe
 * @property string $descripcion
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Cliente $cliente
 */
class Pago extends Entity
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
        'cliente_id' => true,
        'puntodeventa_id' => true,
        'user_id' => true,
        'venta_id' => true,
        'compra_id' => true,
        'fecha' => true,
        'importe' => true,
        'descripcion' => true,
        'created' => true,
        'modified' => true,
        'cliente' => true,
        'tipo' => true,
        'metodo' => true,
        'numero' => true,
    ];
}
