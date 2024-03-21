<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Venta Entity
 *
 * @property int $id
 * @property bool $presupuesto
 * @property int $cliente_id
 * @property int $puntodeventa_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $fecha
 * @property float $neto
 * @property float $porcentajedescuento
 * @property float $importedescuento
 * @property float $iva
 * @property float $total
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\Puntodeventa $puntodeventa
 * @property \App\Model\Entity\User $user
 */
class Venta extends Entity
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
        'puntodeventa_id' => true,
        'comprobante_id' => true,
        'user_id' => true,
        'fecha' => true,
        'neto' => true,
        'porcentajedescuento' => true,
        'importedescuento' => true,
        'iva' => true,
        'imptributos' => true,
        'importeivaexento' => true,
        'importenetogravado' => true,
        'total' => true,
        'created' => true,
        'modified' => true,
        'cliente' => true,
        'puntodeventa' => true,
        'numero' => true,
        'user' => true,
        'cobrado' => true,
        //declaracion de venta
        'comprobantedesde'=> true,
        'comprobantehasta'=> true,
        'cae'=> true,
        'fechavto'=> true,
        'concepto'=> true,
        'servdesde'=> true,
        'servhasta'=> true,
        'vtopago'=> true,
        'condicioniva'=> true,
        'fcuit' => true,
        'fnombre' => true,
        'fdomicilio' => true,
        'fneto' => true,
        'fporcentajedescuento' => true,
        'fimportedescuento' => true,
        'fiva' => true,
        'fimptributos' => true,
        'fimporteivaexento' => true,
        'fimportenetogravado' => true,
        'ftotal' => true,
    ];
}
