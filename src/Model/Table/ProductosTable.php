<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;
use Cake\Http\Response;
/**
 * Productos Model
 *
 * @property \App\Model\Table\RubrosTable|\Cake\ORM\Association\BelongsTo $Rubros
 * @property \App\Model\Table\DetallecomprasTable|\Cake\ORM\Association\HasMany $Detallecompras
 * @property \App\Model\Table\DetalleventasTable|\Cake\ORM\Association\HasMany $Detalleventas
 *
 * @method \App\Model\Entity\Producto get($primaryKey, $options = [])
 * @method \App\Model\Entity\Producto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Producto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Producto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Producto|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Producto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Producto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Producto findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');

        $this->setTable('productos');
        $this->setDisplayField('FullName');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rubros', [
            'foreignKey' => 'rubro_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Detallecompras', [
            'foreignKey' => 'producto_id'
        ]);
        $this->hasMany('Detalleventas', [
            'foreignKey' => 'producto_id'
        ]);
        $this->hasMany('Promotions', [
            'foreignKey' => 'producto_id'
        ]);
        $this->hasMany('ProductoPromotions', [
            'foreignKey' => 'productopromocion_id'
        ]);
    }

    public function actualizarPrecioPorRubro($rubro,$incremento){
        $productos = TableRegistry::get('Productos');
        $incTotal = 1+($incremento/100); 
        $query = $productos->query();
        $query2 = $productos->query();
        $query3 = $productos->query();
        $query->update()
            ->set(
                [
                    'costo = ROUND(costo * '.$incTotal.', 2)',
                    'modified'=>date('Y-m-d h:i:s'),
                ]
            )
            ->where(['rubro_id' => $rubro])
            ->execute(); 

        $query2->update()
            ->set(
                [
                    'precio = ROUND(costo * (1+ganancia/100), 0)',
                    'preciopack = ROUND(costo*(1+gananciapack/100),2)',
                    'preciomayor4 = ROUND(costo*(1+ganancia4/100),2)',
                    'preciomayor3 = ROUND(costo*(1+ganancia3/100),2)',
                    'preciomayor2 = ROUND(costo*(1+ganancia2/100),2)',
                    'preciomayor1 = ROUND(costo*(1+ganancia1/100),2)',
                ]
            )
            ->where(
                    [
                        'rubro_id' => $rubro,
                        'promocion = 0',
                    ]
            )
            ->execute(); 
        $query3->update()
            ->set(
                [
                    'preciopack0 = ROUND(preciopack*cantpack,2)',
                    'preciopack1 = ROUND(preciomayor1*cantpack,2)',
                    'preciopack2 = ROUND(preciomayor2*cantpack,2)',
                    'preciopack3 = ROUND(preciomayor3*cantpack,2)',
                    'preciopack4 = ROUND(preciomayor4*cantpack,2)',
                ]
            )
            ->where(
                    [
                        'rubro_id' => $rubro,
                        'promocion = 0',
                    ]
            )
            ->execute(); 
        return true; 

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 250)
            ->allowEmpty('nombre');

        $validator
            ->numeric('precio')
            ->allowEmpty('precio');

        $validator
            ->numeric('costo')
            ->allowEmpty('costo');

        $validator
            ->numeric('ganancia')
            ->allowEmpty('ganancia');

        $validator
            ->numeric('gananciapack')
            ->allowEmpty('gananciapack');

        $validator
            ->numeric('preciopack')
            ->allowEmpty('preciopack');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 50)
            ->allowEmpty('codigo');

        $validator
            ->scalar('codigopack')
            ->maxLength('codigopack', 50)
            ->allowEmpty('codigopack');

        $validator
            ->integer('cantpack')
            ->allowEmpty('cantpack');

        $validator
            ->integer('stockminimo')
            ->allowEmpty('stockminimo');

        $validator
            ->integer('stock')
            ->allowEmpty('stock');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->existsIn(['rubro_id'], 'Rubros'));

        return $rules;
    }
    public function beforeFind(Event $event, Query $query, $options, $primary) {
        $query->order(['Productos.nombre' => 'ASC']);
        return $query;
    }
    public function updatePrecioPromocion($id){
         $conditionsproduct = [
            'contain' => [
                'Promotions'
            ],
            'conditions' => [
                'Productos.promocion' => 1
            ]
        ];
        $productos = $this->find('all',$conditionsproduct);
        foreach ($productos as $kp => $producto) {
            $actualizame = false;
            $nuevoCosto = 0;
            $nuevoPrecio = 0;
            foreach ($producto->promotions as $kpp => $productoPromotion) {
                if($productoPromotion->productopromocion_id == $id){
                    $actualizame = true;
                }
                $costo = $productoPromotion['costo'];
                $precio = $productoPromotion['precio'];
                $cantidad = $productoPromotion['cantidad'];
                $nuevoPrecio += $precio * $cantidad;
                $nuevoCosto += $costo * $cantidad;
            }
            if($actualizame){
                $tblproductos = TableRegistry::get('Productos');
                $miproducto = $tblproductos->get($producto->id); 
                $miproducto->costo = $nuevoCosto;
                $miproducto->precio = $nuevoPrecio;
                $tblproductos->save($miproducto);
            }
        }
        
    }
}
