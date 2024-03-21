<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Http\Response;
use Afip;
/**
 * Ventas Controller
 *
 * @property \App\Model\Table\VentasTable $Ventas
 *
 * @method \App\Model\Entity\Venta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VentasController extends AppController
{
    //public $AFIPIsProduction = false; //Homologacion
    public $AFIPIsProduction = true; //Produccion
    public $condicionesiva = [
      1 => 'IVA Responsable Inscripto',
      4 => 'IVA Sujeto Exento',
      5 => 'Consumidor Final',
      6 => 'Responsable Monotributo',
      8 => 'Proveedor del Exterior',
      9 => 'Cliente del Exterior',
      10 => 'IVA Liberado - Ley Nº 19.640',
      11 => 'IVA Responsable Inscripto - Agente de Percepción',
      13 => 'Monotributista Social',
      15 => 'IVA No Alcanzado',
    ];
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

    }
    public function beforeRender(\Cake\Event\Event $event) {
        parent::beforeRender($event);
        if ($this->getRequest()->is('ajax') || $this->getRequest()->is('json')){
            $this->viewBuilder()->setClassName('Json');
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $fechaVentasDesde = date('d-m-Y');
        $fechaVentasHasta = date('d-m-Y');
        if ($this->request->is('post')) {
                $fechaVentasDesde = $this->request->getData()['fecha'];
                $fechaVentasHasta = $this->request->getData()['fechahasta'];
        }
        $fechaconsultadesde = date('Y-m-d',strtotime($fechaVentasDesde));
        $fechaconsultahasta = date('Y-m-d',strtotime($fechaVentasHasta));
        $micaja = [];
        $cajaAbierta = false;
        if(!empty($this->viewVars['cajasabiertas'])){
            foreach ($this->viewVars['cajasabiertas'] as $kc => $caja) {
              $micaja = $caja;
              $cajaAbierta = true;
            }
        }
        $conditions = [];
        if($cajaAbierta){
          $conditions = [
              'contain' => ['Clientes', 'Puntodeventas'],
              'conditions'=>[
                  'Ventas.created <= "'.$fechaconsultahasta.' 23:59:59"',
                  'Ventas.created >= "'.$fechaconsultadesde.' 00:00:00"',
                  'Ventas.puntodeventa_id' => $micaja['puntodeventa_id'],
              ]
          ];
        }else{
          $conditions = [
              'contain' => ['Clientes', 'Puntodeventas'],
              'conditions'=>[
                  'Ventas.created <= "'.$fechaconsultahasta.' 23:59:59"',
                  'Ventas.created >= "'.$fechaconsultadesde.' 00:00:00"',
              ]
          ];
        }
        if($this->viewVars['userfiscal']){
          $conditions['conditions'][] = 'Ventas.comprobantedesde IS NOT NULL';
        }
        
        $ventas = $this->Ventas->find('all',$conditions);
        $venta = $this->Ventas->newEntity();
        $session = $this->request->getSession(); // less than 3.5
        $AuthUserTipo = $session->read('Auth.User')['role'];
        $this->set(compact('fechaVentasDesde','fechaVentasHasta','venta','ventas','micaja','AuthUserTipo'));
    }
    public function ventasdiarias()
    {
        $session = $this->request->getSession(); // less than 3.5
        // $session = $this->request->getSession(); // 3.5 or more
        $AuthUserId = $session->read('Auth.User')['id'];
        /*if($AuthUserId!='50e502c3-d8f0-40a0-a0b1-51de0f071349'){
          $this->Flash->error(__('Error. No tiene autorizacion para entrar a esta seccion del sistema.'));
          return $this->redirect(['action' => 'index']);
        }*/
        $fechaVentasDesde = date('d-m-Y',strtotime('-1 months'));
        $fechaVentasHasta = date('d-m-Y');
        if ($this->request->is('post')) {
            $fechaVentasDesde = $this->request->getData()['fecha'];
            $fechaVentasHasta = $this->request->getData()['fechahasta'];
        }
        $fechaconsultadesde = date('Y-m-d',strtotime($fechaVentasDesde));
        $fechaconsultahasta = date('Y-m-d',strtotime($fechaVentasHasta));
            
        //GET VENTAS    
        $tblventas = TableRegistry::get('Ventas');
        $ventas = $tblventas->find();
        $ventas->select([
            'nuevototal' => $ventas->func()->sum('total'),
            'nuevacantidad' => $ventas->func()->count('*'),
            'created','comprobante_id',
        ])
        ->where([
            'Ventas.created <= "'.$fechaconsultahasta.' 23:59:59"',
            'Ventas.created >= "'.$fechaconsultadesde.' 00:00:00"',
            'Ventas.presupuesto'=>0,
        ])
        ->group(['DATE_FORMAT(created,"%d/%m/%Y")','comprobante_id']);
         $miventa = $this->Ventas->newEntity();

        //Get Detalle Ventas
        $tbldetalleventas = TableRegistry::get('Detalleventas');
        $detalleventas = $tbldetalleventas->find();
        $detalleventas->select([
            'nuevacosto' => $detalleventas->func()->sum('costo*cantidad'),
            'nuevosubtotal' => $detalleventas->func()->sum('subtotal'),
            'created'
        ])
        ->where(
            [
                'Detalleventas.venta_id IN (
                    SELECT id FROM ventas AS Ventas
                    WHERE 
                        Ventas.created <= "'.$fechaconsultahasta.' 23:59:59"
                        AND
                        Ventas.created >= "'.$fechaconsultadesde.' 00:00:00"
                        AND
                        Ventas.presupuesto = 0
                )'
            ]
        )->group(['DATE_FORMAT(created,"%d/%m/%Y")']); 
        $this->set(compact('fechaVentasDesde','fechaVentasHasta','ventas','miventa','detalleventas'));

    }
     public function ventasmensuales()
    {
        $session = $this->request->getSession(); // less than 3.5
        // $session = $this->request->getSession(); // 3.5 or more
        $AuthUserId = $session->read('Auth.User')['id'];
        /*if($AuthUserId!='50e502c3-d8f0-40a0-a0b1-51de0f071349'){
          $this->Flash->error(__('Error. No tiene autorizacion para entrar a esta seccion del sistema.'));
          return $this->redirect(['action' => 'index']);
        }*/
        $fechaVentasDesde = date('d-m-Y',strtotime('-12 months'));
        $fechaVentasHasta = date('d-m-Y');
        if ($this->request->is('post')) {
            $fechaVentasDesde = $this->request->getData()['fecha'];
            $fechaVentasHasta = $this->request->getData()['fechahasta'];
        }
        $fechaconsultadesde = date('Y-m-d',strtotime($fechaVentasDesde));
        $fechaconsultahasta = date('Y-m-d',strtotime($fechaVentasHasta));
            
        //GET VENTAS    
        $tblventas = TableRegistry::get('Ventas');
        $ventas = $tblventas->find();
        $ventas->select([
            'nuevototal' => $ventas->func()->sum('total'),
            'nuevacantidad' => $ventas->func()->count('*'),
            'created','comprobante_id',
        ])
        ->where([
            'Ventas.created <= "'.$fechaconsultahasta.' 23:59:59"',
            'Ventas.created >= "'.$fechaconsultadesde.' 00:00:00"',
            'Ventas.presupuesto'=>0,
        ])
        ->group(['DATE_FORMAT(created,"%m/%Y")','comprobante_id']);
         $miventa = $this->Ventas->newEntity();

        //Get Detalle Ventas
        $tbldetalleventas = TableRegistry::get('Detalleventas');
        $detalleventas = $tbldetalleventas->find();
        $detalleventas->select([
            'nuevacosto' => $detalleventas->func()->sum('costo*cantidad'),
            'nuevosubtotal' => $detalleventas->func()->sum('subtotal'),
            'created'
        ])
        ->where(
            [
                'Detalleventas.venta_id IN (
                    SELECT id FROM ventas AS Ventas
                    WHERE 
                        Ventas.created <= "'.$fechaconsultahasta.' 23:59:59"
                        AND
                        Ventas.created >= "'.$fechaconsultadesde.' 00:00:00"
                        AND
                        Ventas.presupuesto = 0
                )'
            ]
        )->group(['DATE_FORMAT(created,"%m/%Y")']); 
        $this->set(compact('fechaVentasDesde','fechaVentasHasta','ventas','miventa','detalleventas'));

    }
    public function listado()
    {
        $fechaVentasDesde = date('d-m-Y');
        $fechaVentasHasta = date('d-m-Y');
        if ($this->request->is('post')) {
                $fechaVentasDesde = $this->request->getData()['fecha'];
                $fechaVentasHasta = $this->request->getData()['fechahasta'];
        }
        $fechaconsultadesde = date('Y-m-d',strtotime($fechaVentasDesde));
        $fechaconsultahasta = date('Y-m-d',strtotime($fechaVentasHasta));
               
        $conditions = [
            'contain' => [
              'Clientes', 
              'Puntodeventas',
              'Pagos',
              'Detalleventas'=>[
                'Productos'
              ],              
            ],
            'conditions'=>[
                'Ventas.created <= "'.$fechaconsultahasta.'"',
                'Ventas.created >= "'.$fechaconsultadesde.'"',
            ],
            'order'=>[
              'Ventas.numero*1 DESC'
            ]
        ];
        if($this->viewVars['userfiscal']){
          $conditions['conditions'][] = 'Ventas.comprobantedesde IS NOT NULL';
        }
        $ventas = $this->Ventas->find('all',$conditions);
        $venta = $this->Ventas->newEntity();
        $this->set(compact('fechaVentasDesde','fechaVentasHasta','venta','ventas','micaja'));
    }

    /**
     * View method
     *
     * @param string|null $id Venta id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null,$original = null)
    {
        $this->loadModel('Puntodeventas');
        $venta = $this->Ventas->get($id, [
            'contain' => [
              'Clientes', 
              'Puntodeventas',
              'Detalleventas'=>[
                'Productos'
              ],
              'Comprobantes',
               'Users']
        ]);

        $this->set('venta', $venta);$micaja = [];       
        $this->set('micaja',$micaja);
        $ventadeclarada = false;
        $afip = $this->Ventas->afipConect($this->AFIPIsProduction); 
        if($venta['comprobantedesde']){
          //App::import('Vendor', 'Afip/Afip');
          /*require_once(ROOT. DS  . 'vendor' . DS  . 'Afip' . DS . 'Afip.php');
          $afip = new Afip([
              'CUIT' => 20330462478,
              'cert' => 'certHomo.crt',
              'key' => 'private',
              'passphrase'=>'private',
              'production'=>false
          ]);            */
          
          //debug($venta);die();
          $numero = $venta->comprobantedesde;
          $PtoVta = $venta->puntodeventa->id;
          $puntodeventa = $this->Puntodeventas->get($PtoVta, [
            'conditions' => [
            ]
          ]);
          $CbteTipo = $venta->comprobante_id;//el comprobante_id es el IDAFIP no de la base de datos                   
          $voucherInfo = $this->Ventas->afipget($afip,'GetVoucherInfo',$puntodeventa['numero'],$CbteTipo,$numero);
          $this->set('voucherInfo', $voucherInfo);
          $ventadeclarada =  true;
        }
        $tiposcomprobantes = $this->Ventas->afipget($afip,'GetVoucherTypes');
        $this->set('tiposcomprobantes', $tiposcomprobantes);
        $this->set('ventadeclarada', $ventadeclarada);
        if($original==null){
          if(!is_null($venta->comprobantedesde)){
            $original=false;
          }else{
            $original=true;  
          }
          
        }

        $this->set('original', $original);
    }

    public function ticketb($id = null,$original = null)
    {
        $this->loadModel('Puntodeventas');
        $venta = $this->Ventas->get($id, [
            'contain' => [
              'Clientes', 
              'Puntodeventas',
              'Detalleventas'=>[
                'Productos'
              ],
              'Comprobantes',
               'Users']
        ]);

        $this->set('venta', $venta);$micaja = [];       
        $this->set('micaja',$micaja);
        $ventadeclarada = false;
        $afip = $this->Ventas->afipConect($this->AFIPIsProduction); 
        if($venta['comprobantedesde']){
          //App::import('Vendor', 'Afip/Afip');
          /*require_once(ROOT. DS  . 'vendor' . DS  . 'Afip' . DS . 'Afip.php');
          $afip = new Afip([
              'CUIT' => 20330462478,
              'cert' => 'certHomo.crt',
              'key' => 'private',
              'passphrase'=>'private',
              'production'=>false
          ]);            */
          
          //debug($venta);die();
          $numero = $venta->comprobantedesde;
          $PtoVta = $venta->puntodeventa->id;
          $puntodeventa = $this->Puntodeventas->get($PtoVta, [
            'conditions' => [
            ]
          ]);
          $CbteTipo = $venta->comprobante_id;//el comprobante_id es el IDAFIP no de la base de datos                   
          $voucherInfo = $this->Ventas->afipget($afip,'GetVoucherInfo',$puntodeventa['numero'],$CbteTipo,$numero);
          $this->set('voucherInfo', $voucherInfo);
          $ventadeclarada =  true;
        }
        $tiposcomprobantes = $this->Ventas->afipget($afip,'GetVoucherTypes');
        $this->set('tiposcomprobantes', $tiposcomprobantes);
        $this->set('ventadeclarada', $ventadeclarada);
        if($original==null){
          if(!is_null($venta->comprobantedesde)){
            $original=false;
          }else{
            $original=true;  
          }
          
        }

        $this->set('original', $original);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /* public function beforeFilter(Event $event) {
         if (in_array($this->request->action, ['addventa'])) {
             $this->eventManager()->off($this->Csrf);
         }
     }*/
    
    public function addventa()
    {
      $this->loadModel('Productos');
      $this->loadModel('Pagos');
      $micaja = [];
      $cajaAbierta = false;
      if(!empty($this->viewVars['cajasabiertas'])){
          foreach ($this->viewVars['cajasabiertas'] as $kc => $caja) {
            $micaja = $caja;
            $cajaAbierta = true;
          }
      }
      if(!$cajaAbierta){
          $this->Flash->error(__('Error. Para agregar una venta primero debe abrir una caja en un punto de venta.'));
          return $this->redirect(['action' => 'index']);
      }
      $this->set('micaja',$micaja);
      $this->loadModel('Detalleventas');
      $venta = $this->Ventas->newEntity();
      $cliente = $this->Ventas->Clientes->newEntity();
      $producto = $this->Productos->newEntity();

      if ($this->request->is('post')) {
              $this->autoRender = false;
              $ventasTable = TableRegistry::get('Ventas');
             // New entity with nested associations
              $entity = $ventasTable->newEntity($this->request->getData(), [
                  'associated' => [
                      'Detalleventas' => ['validate' => false],
                      'Pagos'=> ['validate' => false],
                  ]
              ]);
              $respuesta = "";
              /*hay que asegurarse que la venta tenga el ultimo numero*/
               $topventa = $this->Ventas->find('all',[
                 'fields' => ['ultimaventa' => 'MAX(Ventas.numero*1)'],
                 'conditions'=>[
                      'Ventas.puntodeventa_id'=> $micaja['puntodeventa']['id']
                 ]
              ]); 
              $ultimaventa = iterator_to_array($topventa);
              if ($ventasTable->save($entity)) {
                  // The $article entity contains the id now
                  $id = $entity->id;
                  $respuesta .=  "La venta ha sido guardada. ";
                  //guardamos los detalles de ventas
                  foreach ($this->request->getData()['detalleventas'] as $kdv => $detalle) {
                      $detalleTable = TableRegistry::get('Detalleventas');
                      // New entity with nested associations
                      $entityDV = $detalleTable->newEntity($this->request->getData()['detalleventas'][$kdv], []);
                      $entityDV->venta_id = $id;
                      if ($detalleTable->save($entityDV)) {
                          //$respuesta .=  "El Detalle ha sido Guardado. ";
                          //Ahora vamos a descontar el STOCK de estos productos vendidos
                          if(!$entity->presupuesto){
                            $productos = TableRegistry::get('Productos');
                            $prodid = $this->request->getData()['detalleventas'][$kdv]['producto_id'];
                            $productoStock = $productos->get($prodid)->stock;
                            $nroStock = $productoStock*1 - $this->request->getData()['detalleventas'][$kdv]['cantidad']*1;
                            $query = $productos->query();
                            $query->update()
                                ->set(['stock' => $nroStock])
                                ->where(['id' => $prodid])
                                ->execute();
                            //$respuesta .=  "Stock Actualizado. ".$query;    
                          }
                      }
                      
                  }
                  //fin guardado detalle
                  //guardamos el pago
                  if(!$entity->presupuesto){
                    $pagosTable = TableRegistry::get('Pagos');
                    // New entity with nested associations
                    $entityP = $pagosTable->newEntity($this->request->getData()['pagos'], []);
                    $entityP->venta_id = $id;
                    if ($pagosTable->save($entityP)) {
                      $respuesta .=  "El Cobro ha sido Guardado. ".$entityP->venta_id ;
                    }
                  }
                  //fin guardado pago    
                  $response = $this->response;
                  $data=[
                      'result' => 'success',
                      'venid' => $entity->id,
                      'vennum' => $entity->numero,
                      'respuesta'=>$respuesta];
                  $response = $response->withType('application/json')
                  ->withStringBody(json_encode($data));
                  echo json_encode($data);
                  return $this->response;     
              }
              $respuesta = 'Error. La venta no pudo ser guardada.';
              $response = $this->response;
              $data=['result' => 'fail',
                      'response'=>$respuesta,
                      'data'=>$respuesta];
              echo json_encode($data);
              $response = $response->withType('application/json')
                  ->withStringBody(json_encode($data));
              return $this->response;        

      }
      $clientes = $this->Ventas->Clientes->find('list');
      $puntodeventas = $this->Ventas->Puntodeventas->find('list', ['limit' => 200]);
      $rubros = $this->Productos->Rubros->find('list');
      $users = $this->Ventas->Users->find('list', ['limit' => 200]);
      
      $this->set(compact('venta','cliente','producto','rubros', 'clientes', 'puntodeventas', 'users'));

      $topventa = $this->Ventas->find('all',[
         'fields' => ['ultimaventa' => 'MAX(Ventas.numero*1)'],
         'conditions'=>[
              'Ventas.puntodeventa_id'=> $micaja['puntodeventa']['numero']
         ]
      ]); 
      $ultimaventa = iterator_to_array($topventa);
      $toppago = $this->Pagos->find('all',[
         'fields' => ['ultimopago' => 'MAX(Pagos.numero)'],
         'conditions'=>[
              'Pagos.puntodeventa_id'=> $micaja['puntodeventa']['numero']
         ]
      ]); 
      $ultimopago = iterator_to_array($toppago);

      $session = $this->request->getSession(); // less than 3.5
      // $session = $this->request->getSession(); // 3.5 or more
      $AuthUserId = $session->read('Auth.User')['id'];
      $AuthUserNombre = $session->read('Auth.User')['first_name']." ".$session->read('Auth.User')['last_name'];

      $this->set(compact('AuthUserId','AuthUserNombre','ultimaventa','ultimopago'));

      //Detalle de Ventas
      $detalleventa = $this->Detalleventas->newEntity();
      $productos = $this->Detalleventas->Productos->find('list',[
        'keyField' => 'id',
        'valueField' => 'full_name'
      ]);
      $comprobantes = $this->Ventas->Comprobantes->find('list');
      $this->set(compact('detalleventa','comprobantes','productos'));

      $topproducto = $this->Detalleventas->Productos->find('all',[
         'fields' => ['ultimoproducto' => 'MAX(Productos.codigo*1)'],
         'conditions'=>[
              'Productos.codigo*1 < 10000'
         ]
      ]); 
      $topproducto = iterator_to_array($topproducto);
      $this->set(compact('topproducto'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Venta id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $venta = $this->Ventas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $venta = $this->Ventas->patchEntity($venta, $this->request->getData());
            if ($this->Ventas->save($venta)) {
                $this->Flash->success(__('The venta has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The venta could not be saved. Please, try again.'));
        }
        $clientes = $this->Ventas->Clientes->find('list', ['limit' => 200]);
        $puntodeventas = $this->Ventas->Puntodeventas->find('list', ['limit' => 200]);
        $users = $this->Ventas->Users->find('list', ['limit' => 200]);
        $this->set(compact('venta', 'clientes', 'puntodeventas', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Venta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $venta = $this->Ventas->get($id);
        if ($this->Ventas->delete($venta)) {
            //vamos a buscar todos los detalles que tengan este id
             $conditionsDv = [
                'contain' => [],
                'conditions'=>[
                    'Detalleventas.venta_id'=>$id
                ]
            ];
            $detalleventas = $this->Ventas->Detalleventas->find('all',$conditionsDv);
            $respuesta="";
            foreach ($detalleventas as $kdv => $detalleventa) {
                  //vamos a sumar a los stocks las cantidades de estos detalles
                  $productos = TableRegistry::get('Productos');
                  $prodid = $detalleventa['producto_id'];
                  $productoStock = $productos->get($prodid)->stock;

                  $nroStock = $productoStock*1 + $detalleventa['cantidad']*1;

                  $query = $productos->query();
                  $query->update()
                      ->set(['stock' => $nroStock])
                      ->where(['id' => $prodid])
                      ->execute();
                  $respuesta .=  "Stock Actualizado. ";   
                  //vamos a eliminar estos detalles
                  $dv = $this->Ventas->Detalleventas->get($detalleventa['id']);
                  if ($this->Ventas->delete($venta)) {
                      $respuesta .=  "Detalle de venta eliminado.";   
                  }
            }
            //vamos a buscar todos los pagos que tengan este id
             $conditionsP = [
                'contain' => [],
                'conditions'=>[
                    'Pagos.venta_id'=>$id
                ]
            ];
            $pagos = $this->Ventas->Pagos->find('all',$conditionsP);
            $respuesta="";
            foreach ($pagos as $kp => $pago) {
                  //vamos a eliminar estos detalles
                  $pag = $this->Ventas->Pagos->get($pago['id']);
                  if ($this->Ventas->Pagos->delete($pag)) {
                      $respuesta .=  "Cobro de venta eliminado.";   
                  }
            }
            $this->Flash->success(__('La venta se ha eliminado. '.$respuesta));
        } else {
            $this->Flash->error(__('La venta NO se ha eliminado.Por favor, intente de nuevo mas tarde.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    //PHP AFIP
    
    public function getlastvoucher($PtoVta,$CbteTipo){
        $this->loadModel('Puntodeventas');
        //App::import('Vendor', 'Afip/Afip');
        /*require_once(ROOT. DS  . 'vendor' . DS  . 'Afip' . DS . 'Afip.php');
        $afip = new Afip([
            'CUIT' => 20330462478,
            'cert' => 'certHomo.crt',
            'key' => 'private',
            'passphrase'=>'private',
            'production'=>false
        ]);    */
        $afip = $this->Ventas->afipConect($this->AFIPIsProduction);
        $puntodeventa = $this->Puntodeventas->get($PtoVta, [
            'conditions' => [
            ]
          ]);
        $ultimoComprobanteUsado = $this->Ventas->afipget($afip,'GetLastVoucher',$puntodeventa['numero'],$CbteTipo,0);

        $response['respuesta'] = $ultimoComprobanteUsado['respuesta'][0];
        $response = $this->response;
        $data=['result' => 'success',
                'response'=>$ultimoComprobanteUsado['respuesta'][0],
                'error'=>0,
                ];
        echo json_encode($data);
        $response = $response->withType('application/json')
            ->withStringBody(json_encode($data));
        return $this->response; 
    }
    public function GetPointOfSales(){
        /*App::import('Vendor', 'Afip/Afip');
        $afip = new Afip([
            'CUIT' => 20330462478,
            'cert' => 'certHomo.crt',
            'key' => 'private',
            'passphrase'=>'private',
            'production'=>false
        ]);    */
        $afip = $this->Ventas->afipConect($this->AFIPIsProduction);
        $puntodeventas = $this->Gestionventa->afipget($afip,'GetPointOfSales',0,0,0);

        $response['respuesta'] = $puntodeventas;
        $this->layout = 'ajax';
        $this->set('data', $response);
        $this->render('serializejson');
    }
    public function declararventa($id=null, $impTicket=null) {
        //*Primero que nada vamos a ver si la venta ya esta declarada
        //o sea si tiene numero de venta de AFIP que ya se haya guardado, si ese es el caso
        //redireccionaremos al view
         $ventasTable= TableRegistry::get('Ventas');
         $venta = $ventasTable->get($id);
         if(!is_null($venta->comprobantedesde)){
            $this->Flash->error(__('Error. Esta venta ya esta declarada.'));
            return $this->redirect(['action' => 'view',$id]);
         }
         //si es presupuesto tambien tengo que safar
         if($venta->presupuesto==1){
            $this->Flash->error(__('Error. Esto es un presupuesto. No se puede declar.'));
            return $this->redirect(['action' => 'view',$id]);
         }
        $this->loadModel('Puntodeventas');
        //App::import('Vendor', 'Afip/Afip');
        //require_once(ROOT. DS  . 'vendor' . DS  . 'Afip' . DS . 'Afip.php');
        //$cliente_id = $this->Session->read('Auth.User.cliente_id');
        //Servicio de testing NO BORRAR
        /*$afip = new Afip([
              'CUIT' => 20330462478,
              'cert' => 'certHomo.crt',
              'key' => 'private',
              'passphrase'=>'private',
              'production'=>false
          ]);    */
          $afip = $this->Ventas->afipConect($this->AFIPIsProduction);
        if($this->request->is(array('post', 'put'))) {
          //App::import('Vendor', 'Afip/Afip');
          $Iva = [];
          foreach ($this->request->data['alicuotas'] as $key => $alicuota) {
            if($alicuota['baseimponible']*1==0)continue;
              $alicuotaAAgregar =  array(
                              'Id'        => $alicuota['idafip'], // Id del tipo de IVA (ver tipos disponibles) 
                              'BaseImp'   => $alicuota['baseimponible'], // Base imponible
                              'Importe'   => $alicuota['importe'] // Importe 
                      );
              $Iva[] = $alicuotaAAgregar;
          }
          $Tributos = [];
          if(isset($this->request->data['tributos'])){
            foreach ($this->request->data['tributos'] as $key => $tributo) {
                $tributoAAgregar =  array(
                              'Id'        => $tributo['idafip'], // Id del tipo de tributo (ver tipos disponibles) 
                              'Desc'      => $tributo['descripcion'], // (Opcional) Descripcion
                              'BaseImp'   => $tributo['baseimponible'] , // Base imponible para el tributo
                              'Alic'      => $tributo['alicuota'], // Alícuota
                              'Importe'   => $tributo['importe'] // Importe del tributo
                        );
                $Tributos[] = $tributoAAgregar;
            }
          }
          /*$Iva=array( // (Opcional) Alícuotas asociadas al comprobante
                      array(
                              'Id'        => 5, // Id del tipo de IVA (ver tipos disponibles) 
                              'BaseImp'   => 100, // Base imponible
                              'Importe'   => 21 // Importe 
                      )
              );
            $Tributos=array( // (Opcional) Tributos asociados al comprobante
                      array(
                              'Id'        =>  99, // Id del tipo de tributo (ver tipos disponibles) 
                              'Desc'      => 'Ingresos Brutos', // (Opcional) Descripcion
                              'BaseImp'   => 100, // Base imponible para el tributo
                              'Alic'      => 10, // Alícuota
                              'Importe'   => 10 // Importe del tributo
                      )
              );    */     
          /*Vamos a buscar el punto de venta donde se hizo la venta y vamos a traer el numero*/
          $puntodeventa = $this->Puntodeventas->get($this->request->data['puntodeventas_id'], [
            'conditions' => [
                
            ]
          ]);          
          $data = array(
              'CantReg'     => 1, // Cantidad de comprobantes a registrar
              'PtoVta'      => $puntodeventa['numero'], // Punto de venta
              'CbteTipo'    => $this->request->data['comprobante_id'], // Tipo de comprobante (ver tipos disponibles) 
              'Concepto'    => $this->request->data['concepto'], // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
              'DocTipo'     => $this->request->data['tipodocumento']*1, // Tipo de documento del comprador (ver tipos disponibles)
              'DocNro'    =>  $this->request->data['fcuit']*1, // Numero de documento del comprador
              'CbteDesde'   => $this->request->data['comprobantedesde'], // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
              'CbteHasta'   => $this->request->data['comprobantehasta'], // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
              'CbteFch'     => intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
              'ImpTotal'    => $this->request->data['ftotal'], // Importe total del comprobante
              'ImpTotConc'  => $this->request->data['fimportenetonogravado'], // Importe neto no gravado
              'ImpNeto'     => $this->request->data['fneto'], // Importe neto gravado
              'ImpOpEx'     => $this->request->data['fimportenetoivaexento'], // Importe exento de IVA
              'ImpIVA'    => $this->request->data['fiva'], //Importe total de IVA
              'ImpTrib'     => $this->request->data['fimptributos'],  //Importe total de tributos
              'FchServDesde'  => NULL, // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
              'FchServHasta'  => NULL, // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
              'FchVtoPago'  => NULL, // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
              'MonId'     => 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
              'MonCotiz'    => 1, // Cotización de la moneda usada (1 para pesos argentinos)  
             /*'CbtesAsoc'  => array( // (Opcional) Comprobantes asociados
                      array(
                              'Tipo'    => 991, // Tipo de comprobante (ver tipos disponibles) 
                              'PtoVta'  => 1, // Punto de venta
                              'Nro'     => 1, // Numero de comprobante
                              'Cuit'    => 20111111112 // (Opcional) Cuit del emisor del comprobante
                              )
                      ),*/
              //'Tributos'      => $Tributos, 
              
              /*'Opcionales'  => array( // (Opcional) Campos auxiliares
                      array(
                              'Id'    => 17, // Codigo de tipo de opcion (ver tipos disponibles) 
                              'Valor'   => 2 // Valor 
                      )
              ),   */              
              //                'Compradores'   => array( // (Opcional) Detalles de los clientes del comprobante 
              //                        array(
              //                                'DocTipo'     => 80, // Tipo de documento (ver tipos disponibles) 
              //                                'DocNro'    => 20111111112, // Numero de documento
              //                                'Porcentaje'  => 100 // Porcentaje de titularidad del comprador
              //                        )
              //                )
          );
          //si es factura C no mandemos el objeto IVA
          $comprobantesFC = [11,12,13,15];
          if(!in_array($this->request->data['comprobante_id'], $comprobantesFC)){
            $data['Iva']=$Iva;
          }else{
            //si es factura 0 el IVA da 0;
            $data['ImpIVA']=0;
          }
          if(count($Tributos)>0){
            $data['Tributos'] = $Tributos;
          }
          try {
            /*************************/
            $respuesta = $afip->ElectronicBilling->CreateVoucher($data);
            $cae = $respuesta['CAE'];
            $CAEFchVto = $respuesta['CAEFchVto'];
            /*************************/
            $result = 'success';
            $error = 0;
            $datosenviados = [];
            /*si los datos fueron guardados los datos tenemos que atualizar los datos de la venta en la base de datos*/
           
            $ventasTable= TableRegistry::get('Ventas');
            $venta = $ventasTable->get($this->request->data['id'],[
              'contain'=>['Clientes']
            ]);
            $venta->comprobantedesde = $this->request->data['comprobantedesde'];
            $venta->comprobantehasta = $this->request->data['comprobantehasta'];
            $venta->cae = $cae;
            $venta->fechavto = $CAEFchVto;
            $venta->comprobante_id = $this->request->data['comprobante_id'];
            /*Antes de guardar los datos del cliente vamos a preguntar si cambiaron, y si cambiaron vamos a registrar otro cliente*/
            if($venta->cliente->CUIT!=$this->request->getData()['fcuit']){
              /*Cambio el CUIT vamos a guardar el nuevo cliente*/
              $clienteTable = TableRegistry::get('Clientes');
              $clientesOld = $clienteTable->find('all',[
                'conditions'=>[
                  'Clientes.CUIT' => $this->request->data['fcuit'],
                ]
              ]);
              $hayClienteNuevo = true;
              foreach ($clientesOld as $kco => $cliente) {
                 $venta->cliente_id = $cliente->id;
                 $hayClienteNuevo = false;
              }
              if($hayClienteNuevo){
                $entityclente = $clienteTable->newEntity();
                $entityclente->nombre = $this->request->data['fnombre'];
                $entityclente->direccion = $this->request->data['fdomicilio'];
                $entityclente->CUIT = $this->request->data['fcuit'];
                $entityclente->condicioniva = $this->request->data['condicioniva'];
                if ($clienteTable->save($entityclente)) {
                  $datosenviados['Cliente'] =  "El Cliente Nuevo ha sido Guardado. ";
                }
              }
            }
            /**/
            /*Datos del cliente que se guardo*/
            $venta->fcuit = $this->request->data['fcuit'];
            $venta->fnombre = $this->request->data['fnombre'];
            $venta->fdomicilio = $this->request->data['fdomicilio'];
            $venta->condicioniva = $this->request->data['condicioniva'];
            /*Aca vamos a guardar todos los datos de la venta que se guardo*/
            $venta->fneto = $this->request->data['fneto'];
            $venta->fiva = $this->request->data['fiva'];
            $venta->fimptributos = $this->request->data['fimptributos'];
            $venta->fimporteivaexento = $this->request->data['fimportenetoivaexento'];
            $venta->ftotal = $this->request->data['ftotal'];
            $venta->fimportenetogravado = $this->request->data['fimportenetonogravado'];
            $venta->condicioniva = $this->request->data['condicioniva'];
            $venta->puntodeventa_id = $this->request->data['puntodeventas_id'];
             
            if($ventasTable->save($venta)){
              $datosenviados['ventaguardada']=$venta;
            } else {
              $datosenviados['ventaerror'] ='error al guardar esta venta';
            }

            $alicuotasTable = TableRegistry::get('Alicuotas');
            $datosenviados['alicuotaguardada'] = [];
            $datosenviados['alicuotaerror'] = [];
            $datosenviados['detallesguardados'] = [];
            $datosenviados['detalleventaerror'] = [];
            foreach ($this->request->data['alicuotas'] as $kalic => $alicuota) {
               // New entity with nested associations
                $alicuotaEntity = $alicuotasTable->newEntity($alicuota, [ ]);
                if($alicuotasTable->save($alicuotaEntity)){
                  $datosenviados['alicuotaguardada'][] =$alicuota ; 
                }else{
                  $datosenviados['alicuotaerror'][] =$alicuota ;
                }
                
            }
            //Ahora vamos a guardar los detalles de las ventas nuevos
            foreach ($this->request->data['detalleventas'] as $key => $detalleventa) {
              $detalleVentasTable= TableRegistry::get('Detalleventas');
              $detalleventaEntity = $detalleVentasTable->get($detalleventa['id']);
              $detalleventaEntity->fcantidad = $detalleventa['fcantidad'];
              $detalleventaEntity->fporcentajedescuento = $detalleventa['fporcentajedescuento'];
              $detalleventaEntity->fprecio = $detalleventa['fprecio'];
              $detalleventaEntity->fimportedescuento = $detalleventa['fimportedescuento'];
              $detalleventaEntity->fsubtotal = $detalleventa['fsubtotal'];
              $detalleventaEntity->fcodigoalicuota = $detalleventa['fcodigoalicuota'];
              $detalleventaEntity->falicuota = $detalleventa['falicuota'];
              $detalleventaEntity->fimporteiva = $detalleventa['fimporteiva'];
              $detalleventaEntity->fsubtotalconiva = $detalleventa['fsubtotalconiva'];
              if($detalleVentasTable->save($detalleventaEntity)){
                $datosenviados['detallesguardados'][] = $detalleventaEntity;
              } else {
                $datosenviados['detalleventaerror'][] = 'error al guardar este detalle';
              }
            }
          } catch (\Exception $e) {
            //debug($e);die();
            $respuesta = $e->getMessage();
            $result = 'fail';
            $error = 1;//$e->trace[0]['args'][1]->FECAESolicitarResult->Errors;
            $datosenviados = $data;
            $data=['result' => $result,
                 'error'=>$error,
                 'datosenviados'=>$datosenviados,
                 'response'=>$respuesta,
                 ];
            echo json_encode($data);
            $response = $this->response;
            $response = $response->withType('application/json')
                ->withStringBody(json_encode($data));
            return $this->response; 
          }
          $response = $this->response;
          $respuesta = 'La venta se ha guardado con exito.';
          $data=['result' => $result,
                  'error'=>$error,
                  'datosenviados'=>$datosenviados,
                  'response'=>$respuesta,
                  ];
          echo json_encode($data);
          $response = $response->withType('application/json')
              ->withStringBody(json_encode($data));
          return $this->response; 
        }
        
        // $cuitcontribuyente = 20330462478;
        // $taxpayer_details = $afip->RegisterScopeFive->GetTaxpayerDetails((float)$cuitcontribuyente);//fede
        // Debugger::dump("taxpayer details");
        // Debugger::dump($taxpayer_details);
        //$puntosdeventa = $afip->ElectronicBilling->GetPointOfSales();
        //Debugger::dump($puntosdeventa);

        //$last_voucher = $afip->ElectronicBilling->GetLastVoucher(2,11);
        //Debugger::dump($last_voucher);                
        $conditionspuntosdeventa = [];//array('Puntosdeventa.cliente_id' => $cliente_id,);
        $puntodeventas = $this->Puntodeventas->find('list',[
          'conditions' => [
                'facturacionhabilitada'=>1
            ]
        ]);
        //$puntodeventas = $afip->ElectronicBilling->GetPointOfSales();

        $tiposcomprobantes = $afip->ElectronicBilling->GetVoucherTypes();
        $tiposdocumentos = $afip->ElectronicBilling->GetDocumentTypes();
        $tiposmonedas = $afip->ElectronicBilling->GetCurrenciesTypes();
        $tipostributos = $afip->ElectronicBilling->GetTaxTypes();
        $tiposalicuotas = $afip->ElectronicBilling->GetAliquotTypes();
        $tiposopcionales = $afip->ElectronicBilling->GetOptionsTypes();

        $condicionesiva = $this->condicionesiva;

        $venta = $this->Ventas->get($id, [
          'contain' => [
            'Detalleventas'=>[
              'Productos'
            ],
            'Clientes',
            'Puntodeventas',
            'Tributos'
          ]
        ]);
        
        $this->set(compact('venta'));

        $this->set(compact('puntodeventas','tiposcomprobantes',
                'tiposdocumentos','tiposmonedas','tipostributos','tiposalicuotas',
                'tiposopcionales','condicionesiva','listaventas','cliente_id','impTicket'));
        
    }
    public function enviarVentaAAFIP(){
       
    }
    public function afipgetserverstatus(){
        $this->loadModel('Puntodeventas');
        //App::import('Vendor', 'Afip/Afip');
        $session = $this->request->getSession(); // less than 3.5
        // $session = $this->request->getSession(); // 3.5 or more
        $cliente_id = $session->read('Auth.User')['id'];
        $respuesta = [];
        //Servicio de testing NO BORRAR
        /*$afip = new Afip([
            'CUIT' => 20330462478,
            'cert' => 'certHomo.crt',
            'key' => 'private',
            'passphrase'=>'private',
            'production'=>false
        ]);         */
        $afip = $this->Ventas->afipConect($this->AFIPIsProduction);    
        $serverStatus = $afip->ElectronicBilling->GetServerStatus();
        $respuesta['respuesta'] = [$serverStatus];
        $response = $this->response;
        $response = $response->withType('application/json')
          ->withStringBody(json_encode($respuesta));
          echo json_encode($respuesta);
          return $this->response;     
    }

    public function afipgetvoucherinfo($ventaid){
      
    }
}
