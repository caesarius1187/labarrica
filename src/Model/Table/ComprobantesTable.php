<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comprobantes Model
 *
 * @property \App\Model\Table\VentasTable|\Cake\ORM\Association\HasMany $Ventas
 *
 * @method \App\Model\Entity\Comprobante get($primaryKey, $options = [])
 * @method \App\Model\Entity\Comprobante newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Comprobante[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Comprobante|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Comprobante|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Comprobante patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Comprobante[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Comprobante findOrCreate($search, callable $callback = null, $options = [])
 */
class ComprobantesTable extends Table
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

        $this->setTable('comprobantes');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id');

        $this->hasMany('Ventas', [
            'foreignKey' => 'comprobante_id'
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
            ->scalar('nombre')
            ->maxLength('nombre', 250)
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 50)
            ->allowEmpty('codigo');

        $validator
            ->scalar('tipo')
            ->allowEmpty('tipo');

        $validator
            ->scalar('tipodebitoasociado')
            ->allowEmpty('tipodebitoasociado');

        $validator
            ->scalar('tipocreditoasociado')
            ->allowEmpty('tipocreditoasociado');

        $validator
            ->scalar('abreviacion')
            ->maxLength('abreviacion', 50)
            ->allowEmpty('abreviacion');

        $validator
            ->scalar('abreviacion2')
            ->maxLength('abreviacion2', 50)
            ->requirePresence('abreviacion2', 'create')
            ->notEmpty('abreviacion2');

        return $validator;
    }
}
