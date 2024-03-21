<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Compras Model
 *
 * @property \App\Model\Table\DetallecomprasTable|\Cake\ORM\Association\HasMany $Detallecompras
 *
 * @method \App\Model\Entity\Compra get($primaryKey, $options = [])
 * @method \App\Model\Entity\Compra newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Compra[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Compra|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Compra|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Compra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Compra[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Compra findOrCreate($search, callable $callback = null, $options = [])
 */
class ComprasTable extends Table
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

        $this->setTable('compras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->hasMany('Detallecompras', [
            'foreignKey' => 'compra_id'
        ]);
        $this->hasMany('Pagos', [
            'foreignKey' => 'compra_id'
        ]);
        $this->belongsTo('Puntodeventas', [
            'foreignKey' => 'puntodeventa_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Comprobantes', [
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
        /*$validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmpty('fecha');

        $validator
            ->numeric('neto')
            ->requirePresence('neto', 'create')
            ->notEmpty('neto');

        $validator
            ->numeric('iva')
            ->allowEmpty('iva');

        $validator
            ->numeric('total')
            ->allowEmpty('total');*/

        return $validator;
    }
    public function beforeSave($event, $entity, $options) {
        //debug($entity);
        $entity->fecha = date('Y-m-d H:i:s', strtotime($entity->fecha));
    }
}
