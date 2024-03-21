<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Puntodeventas Model
 *
 * @property \App\Model\Table\VentasTable|\Cake\ORM\Association\HasMany $Ventas
 *
 * @method \App\Model\Entity\Puntodeventa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Puntodeventa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Puntodeventa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Puntodeventa|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Puntodeventa|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Puntodeventa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Puntodeventa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Puntodeventa findOrCreate($search, callable $callback = null, $options = [])
 */
class PuntodeventasTable extends Table
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

        $this->setTable('puntodeventas');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->hasMany('Ventas', [
            'foreignKey' => 'puntodeventa_id'
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
            ->integer('numero')
            ->requirePresence('numero', 'create')
            ->notEmpty('numero');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 100)
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 250)
            ->requirePresence('descripcion', 'create')
            ->notEmpty('descripcion');

        return $validator;
    }
}
