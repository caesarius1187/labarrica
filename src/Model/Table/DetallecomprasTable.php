<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Detallecompras Model
 *
 * @property \App\Model\Table\ComprasTable|\Cake\ORM\Association\BelongsTo $Compras
 * @property \App\Model\Table\ProductosTable|\Cake\ORM\Association\BelongsTo $Productos
 *
 * @method \App\Model\Entity\Detallecompra get($primaryKey, $options = [])
 * @method \App\Model\Entity\Detallecompra newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Detallecompra[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Detallecompra|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Detallecompra|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Detallecompra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Detallecompra[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Detallecompra findOrCreate($search, callable $callback = null, $options = [])
 */
class DetallecomprasTable extends Table
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

        $this->setTable('detallecompras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Compras', [
            'foreignKey' => 'compra_id'
        ]);
        $this->belongsTo('Productos', [
            'foreignKey' => 'producto_id'
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
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('cantidad')
            ->allowEmpty('cantidad');

        $validator
            ->numeric('precio')
            ->allowEmpty('precio');

        $validator
            ->numeric('porcentajeganancia')
            ->allowEmpty('porcentajeganancia');

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
        $rules->add($rules->existsIn(['compra_id'], 'Compras'));
        $rules->add($rules->existsIn(['producto_id'], 'Productos'));

        return $rules;
    }
}
