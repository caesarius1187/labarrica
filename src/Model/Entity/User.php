<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $dni
 * @property string $telefono
 * @property string $cel
 * @property string $mail
 * @property string $nombre
 * @property string $matricula
 * @property string $folio
 * @property string $username
 * @property string $password
 * @property string $tipo
 * @property string $estado
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Caja[] $cajas
 * @property \App\Model\Entity\Venta[] $ventas
 */
class User extends Entity
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
    // Make all fields mass assignable for now.
    protected $_accessible = ['*' => true];

    // ...

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    /*protected $_accessible = [
        'dni' => true,
        'telefono' => true,
        'cel' => true,
        'mail' => true,
        'nombre' => true,
        'matricula' => true,
        'folio' => true,
        'username' => true,
        'password' => true,
        'tipo' => true,
        'estado' => true,
        'created' => true,
        'modified' => true,
        'cajas' => true,
        'ventas' => true
    ];*/

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
