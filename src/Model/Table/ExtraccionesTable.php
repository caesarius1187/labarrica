<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Extracciones Model
 *
 * @method \App\Model\Entity\Extraccione get($primaryKey, $options = [])
 * @method \App\Model\Entity\Extraccione newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Extraccione[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Extraccione|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Extraccione|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Extraccione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Extraccione[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Extraccione findOrCreate($search, callable $callback = null, $options = [])
 */
class ExtraccionesTable extends Table
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

        $this->setTable('extracciones');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Puntodeventas', [
            'foreignKey' => 'puntodeventa_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->scalar('descripcion')
            ->maxLength('descripcion', 250)
            ->allowEmpty('descripcion');

        $validator
            ->numeric('importe')
            ->allowEmpty('importe');

        $validator
            ->numeric('saldo')
            ->allowEmpty('saldo');

        $validator
            ->dateTime('fecha')
            ->allowEmpty('fecha');

        return $validator;
    }
    public function beforeSave($event, $entity, $options) {
        debug($entity);
        $entity->fecha = date('Y-m-d h:i:s', strtotime($entity->fecha));
    }
}
