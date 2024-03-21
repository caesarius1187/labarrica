<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

/**
 * Cajas Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PuntodeventasTable|\Cake\ORM\Association\BelongsTo $Puntodeventas
 *
 * @method \App\Model\Entity\Caja get($primaryKey, $options = [])
 * @method \App\Model\Entity\Caja newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Caja[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Caja|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Caja|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Caja patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Caja[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Caja findOrCreate($search, callable $callback = null, $options = [])
 */
class CajasTable extends Table
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
        $this->setTable('cajas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Puntodeventas', [
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
       /* $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('apertura')
            ->allowEmpty('apertura');

        $validator
            ->numeric('importeapertura')
            ->allowEmpty('importeapertura');

        $validator
            ->dateTime('cierre')
            ->allowEmpty('cierre');

        $validator
            ->numeric('importecierre')
            ->allowEmpty('importecierre');*/

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['puntodeventa_id'], 'Puntodeventas'));

        return $rules;
    }
    public function beforeSave($event, $entity, $options) {
        //debug($entity);
        if(isset($entity->apertura)){
            $entity->apertura = date('Y-m-d H:i:s', strtotime($entity->apertura));
        }
        if(isset($entity->cierre)){
            $entity->cierre = date('Y-m-d H:i:s', strtotime($entity->cierre));
        }
    }
    public function beforeFind(Event $event, Query $query, $options, $primary) {
        $query->order(['Cajas.apertura' => 'DESC']);
        return $query;
    }
}
