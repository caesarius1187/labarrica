<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Controller\AppController;
use Cake\Core\App;
use Cake\Event\Event;
use Cake\Http\Response;
use Afip;
/**
 * Ventas Model
 *
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 * @property \App\Model\Table\PuntodeventasTable|\Cake\ORM\Association\BelongsTo $Puntodeventas
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Venta get($primaryKey, $options = [])
 * @method \App\Model\Entity\Venta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Venta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Venta|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Venta|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Venta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Venta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Venta findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VentasTable extends Table
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

        $this->setTable('ventas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');



        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Puntodeventas', [
            'foreignKey' => 'puntodeventa_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Detalleventas', [
            'foreignKey' => 'venta_id'
        ]);
        $this->hasMany('Pagos', [
            'foreignKey' => 'venta_id'
        ]);
        $this->hasMany('Tributos', [
            'foreignKey' => 'venta_id'
        ]);
        $this->hasMany('Alicuotas', [
            'foreignKey' => 'venta_id'
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
            ->boolean('presupuesto')
            ->allowEmpty('presupuesto');

        $validator
            ->dateTime('fecha')
            ->allowEmpty('fecha');

        $validator
            ->numeric('neto')
            ->allowEmpty('neto');

        $validator
            ->numeric('porcentajedescuento')
            ->allowEmpty('porcentajedescuento');

        $validator
            ->numeric('importedescuento')
            ->allowEmpty('importedescuento');

        $validator
            ->numeric('iva')
            ->allowEmpty('iva');

        $validator
            ->numeric('total')
            ->allowEmpty('total');*/

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
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));
        $rules->add($rules->existsIn(['puntodeventa_id'], 'Puntodeventas'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
    public function beforeSave($event, $entity, $options) {
        //debug($entity);
        $entity->fecha = date('Y-m-d H:i:s', strtotime($entity->fecha));
    }
    /*PHP FOR AFIP CONECTIONS*/
    
    public function afipConect($isProduction){
        //App::import('Vendor', 'Afip/Afip');
        require_once(ROOT. DS  . 'vendor' . DS  . 'Afip' . DS . 'Afip.php');
        //Conecciones de la barrica
        if($isProduction){
            $afip = new Afip([
                'CUIT' => 24250699154,
                'cert' => 'labarrica_1fa1292a3f569790.crt',
                'key' => 'privadaLB2023',
                'passphrase'=>'privadaLB2023',
                'production'=>true
            ]);   
        }else{
            $afip = new Afip([
                'CUIT' => 24250699154,
                'cert' => 'crtHomologacionLaBarrica',
                'key' => 'privada24250699154',
                'passphrase'=>'privada24250699154',
                'production'=>false
            ]);   
        }
        /*
        //Conecciones de Augusto
        if($isProduction){
            $afip = new Afip([
                'CUIT' => 20330462478,
                'cert' => 'labarrica_396f531ae9406817.crt',
                'key' => 'privada20330462478',
                'passphrase'=>'privada20330462478',
                'production'=>true
            ]);   
        }else{
            $afip = new Afip([
                'CUIT' => 20330462478,
                'cert' => 'certHomo.crt',
                'key' => 'private',
                'passphrase'=>'private',
                'production'=>false
            ]);   
        }*/
        return $afip;
    }
    public function afipget($afipClass,$funcionAFIP=null,$puntoDeVenta=null,$tipoFactura=null,$numero=null){
        //$this->loadModel('Puntosdeventa');
        

        $tipos = [];
        switch ($funcionAFIP) {
            case 'GetLastVoucher':
                $tipos = $afipClass->ElectronicBilling->GetLastVoucher($puntoDeVenta,$tipoFactura);
                break;
            case 'GetVoucherTypes':
                $tipos = $afipClass->ElectronicBilling->GetVoucherTypes();
                break;
            case 'GetDocumentTypes':
                $tipos = $afipClass->ElectronicBilling->GetDocumentTypes();
                break;
            case 'GetCurrenciesTypes':
                $tipos = $afipClass->ElectronicBilling->GetCurrenciesTypes();
                break;
            case 'GetTaxTypes':
                $tipos = $afipClass->ElectronicBilling->GetTaxTypes();
                break;
            case 'GetAliquotTypes':
                $tipos = $afipClass->ElectronicBilling->GetAliquotTypes();
                break;
            case 'GetOptionsTypes':
                $tipos = $afipClass->ElectronicBilling->GetOptionsTypes();
                break;
            case 'GetVoucherInfo':
                $tipos = $afipClass->ElectronicBilling->GetVoucherInfo($numero, $puntoDeVenta, $tipoFactura);
                break;
            case 'GetPointOfSales':
                $tipos = $afipClass->ElectronicBilling->GetPointOfSales();
                break;    
            default:
                break;
        }
        $response['respuesta'] = [$tipos];
        return $response;
    }
    /*FIN AFÏP*/
}
