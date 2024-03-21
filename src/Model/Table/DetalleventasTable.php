<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Detalleventas Model
 *
 * @property \App\Model\Table\ProductosTable|\Cake\ORM\Association\BelongsTo $Productos
 *
 * @method \App\Model\Entity\Detalleventa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Detalleventa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Detalleventa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Detalleventa|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Detalleventa|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Detalleventa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Detalleventa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Detalleventa findOrCreate($search, callable $callback = null, $options = [])
 */
class DetalleventasTable extends Table
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

        $this->setTable('detalleventas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Productos', [
            'foreignKey' => 'producto_id'
        ]);
        $this->belongsTo('Ventas', [
            'foreignKey' => 'venta_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        /*$validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->numeric('precio')
            ->allowEmpty('precio');

        $validator
            ->integer('cantidad')
            ->allowEmpty('cantidad');

        $validator
            ->numeric('porcentajedescuento')
            ->allowEmpty('porcentajedescuento');

        $validator
            ->numeric('importedescuento')
            ->allowEmpty('importedescuento');

        $validator
            ->numeric('subtotal')
            ->allowEmpty('subtotal');*/

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
        $rules->add($rules->existsIn(['producto_id'], 'Productos'));

        return $rules;
    }
}
