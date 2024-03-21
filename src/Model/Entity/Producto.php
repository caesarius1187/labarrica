<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Producto Entity
 *
 * @property int $id
 * @property int $rubro_id
 * @property string $nombre
 * @property float $precio
 * @property float $costo
 * @property float $ganancia
 * @property float $gananciapack
 * @property float $preciopack
 * @property string $codigo
 * @property string $codigopack
 * @property int $cantpack
 * @property int $stockminimo
 * @property int $stock
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Rubro $rubro
 * @property \App\Model\Entity\Detallecompra[] $detallecompras
 * @property \App\Model\Entity\Detalleventa[] $detalleventas
 */
class Producto extends Entity
{

    protected $_virtual = ['full_name'];

    protected function _getFullName() {
        $nombre = "";
        if(isset($this->_properties['nombre'])){
            $nombre = $this->_properties['nombre'];
        }

        $codigo = "";
        if(isset($this->_properties['codigo'])){
            $codigo = $this->_properties['codigo'];
        }
        $precio = "";
        if(isset($this->_properties['precio'])){
            $precio = $this->_properties['precio'];
        }
        $preciopack = "";
        if(isset($this->_properties['preciopack0'])){
            $preciopack = $this->_properties['preciopack0'];
        }
        return $nombre  . '//' . $codigo . '//$' . number_format($precio*1,2,',','.'). '//$' . number_format($preciopack*1,2,',','.');
    }
    
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
        'rubro_id' => true,
        'nombre' => true,
        'precio' => true,
        'costo' => true,
        'ganancia' => true,
        'gananciapack' => true,
        'ganancia1' => true,
        'ganancia2' => true,
        'ganancia3' => true,
        'ganancia4' => true,
        'preciomayor1' => true,
        'preciomayor2' => true,
        'preciomayor3' => true,
        'preciomayor4' => true,
        'preciopack' => true,
        'preciopack4' => true,
        'preciopack3' => true,
        'preciopack2' => true,
        'preciopack1' => true,
        'preciopack0' => true,
        'codigo' => true,
        'codigopack' => true,
        'cantpack' => true,
        'stockminimo' => true,
        'stock' => true,
        'created' => true,
        'modified' => true,
        'rubro' => true,
        'detallecompras' => true,
        'detalleventas' => true,
        'promocion' => true
    ];
}
