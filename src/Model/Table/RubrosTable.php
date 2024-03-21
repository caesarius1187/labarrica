<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

/**
 * Rubros Model
 *
 * @property \App\Model\Table\ProductosTable|\Cake\ORM\Association\HasMany $Productos
 *
 * @method \App\Model\Entity\Rubro get($primaryKey, $options = [])
 * @method \App\Model\Entity\Rubro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Rubro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Rubro|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rubro|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rubro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Rubro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Rubro findOrCreate($search, callable $callback = null, $options = [])
 */
class RubrosTable extends Table
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

        $this->setTable('rubros');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->hasMany('Productos', [
            'foreignKey' => 'rubro_id'
        ]);
    }
    public function beforeFind(Event $event, Query $query, $options, $primary) {
        $query->order(['Rubros.nombre' => 'ASC']);
        return $query;
    }
   
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('nombre')
            ->allowEmpty('nombre');

        $validator
            ->integer('descripcion')
            ->allowEmpty('descripcion');

        return $validator;
    }*/
}
