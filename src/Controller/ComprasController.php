<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Compras Controller
 *
 * @property \App\Model\Table\ComprasTable $Compras
 *
 * @method \App\Model\Entity\Compra[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ComprasController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $fechaComprasDesde = date('d-m-Y');
        $fechaComprasHasta = date('d-m-Y');
        if ($this->request->is('post')) {
                $fechaComprasDesde = $this->request->getData()['fecha'];
                $fechaComprasHasta = $this->request->getData()['fechahasta'];
        }
        $fechaconsultadesde = date('Y-m-d',strtotime($fechaComprasDesde));
        $fechaconsultahasta = date('Y-m-d',strtotime($fechaComprasHasta));
        $micaja = [];
        $cajaAbierta = false;
        if(!empty($this->viewVars['cajasabiertas'])){
            foreach ($this->viewVars['cajasabiertas'] as $kc => $caja) {
              $micaja = $caja;
              $cajaAbierta = true;
            }
        }
        if($cajaAbierta){
          $conditions = [
              'contain' => ['Clientes', 'Puntodeventas'],
              'conditions'=>[
                  'Compras.fecha <= "'.$fechaconsultahasta.'"',
                  'Compras.fecha >= "'.$fechaconsultadesde.'"',
                  'Compras.puntodeventa_id' => $micaja['puntodeventa_id'],
              ]
          ];
        }else{
          $conditions = [
              'contain' => ['Clientes', 'Puntodeventas'],
              'conditions'=>[
                  'Compras.fecha <= "'.$fechaconsultahasta.'"',
                  'Compras.fecha >= "'.$fechaconsultadesde.'"',
              ]
          ];
        }
        
        $compras = $this->Compras->find('all',$conditions);
        $compra = $this->Compras->newEntity();
        $this->set(compact('fechaComprasDesde','fechaComprasHasta','compra','compras','micaja'));
    }

    /**
     * View method
     *
     * @param string|null $id Compra id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Ventas');
        $compra = $this->Compras->get($id, [
            'contain' => ['Detallecompras'=>['Productos'],'Clientes']
        ]);

        $this->set('compra', $compra);

        //$afip = $this->Ventas->afipConect($this->AFIPIsProduction);         
        //$tiposcomprobantes = $this->Ventas->afipget($afip,'GetVoucherTypes');
        //$this->set('tiposcomprobantes', $tiposcomprobantes);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
     public function add()
    {
      $this->loadModel('Productos');
      $micaja = [];
      $cajaAbierta = false;
      if(!empty($this->viewVars['cajasabiertas'])){
          foreach ($this->viewVars['cajasabiertas'] as $kc => $caja) {
            $micaja = $caja;
            $cajaAbierta = true;
          }
      }
      if(!$cajaAbierta){
          $this->Flash->error(__('Error. Para agregar una compra primero debe abrir una caja en un punto de compra.'));
          return $this->redirect(['action' => 'index']);
      }
      $this->set('micaja',$micaja);
      $this->loadModel('Detallecompras');
      $compra = $this->Compras->newEntity();
      $cliente = $this->Compras->Clientes->newEntity();
      $producto = $this->Productos->newEntity();

      if ($this->request->is('post')) {
              $this->autoRender = false;
              $comprasTable = TableRegistry::get('Compras');
             // New entity with nested associations
              $entity = $comprasTable->newEntity($this->request->getData(), [
                  'associated' => [
                      'Detallecompras' => ['validate' => false]
                  ]
              ]);
              $respuesta = "";
              if ($comprasTable->save($entity)) {
                  // The $article entity contains the id now
                  $id = $entity->id;
                  $respuesta .=  "La compra ha sido guardada. ";
                  //guardamos los detalles de compras
                  foreach ($this->request->getData()['detallecompras'] as $kdv => $detalle) {
                      $detalleTable = TableRegistry::get('Detallecompras');
                      // New entity with nested associations
                      $entityDV = $detalleTable->newEntity($this->request->getData()['detallecompras'][$kdv], [
                      ]);
                      $entityDV->compra_id = $id;
                      if ($detalleTable->save($entityDV)) {
                          $respuesta .=  "El Detalle ha sido Guardado. ";
                          //Ahora vamos a descontar el STOCK de estos productos vendidos
                          $productos = TableRegistry::get('Productos');
                          $prodid = $this->request->getData()['detallecompras'][$kdv]['producto_id'];
                          $productoStock = $productos->get($prodid)->stock;

                          $nroStock = $productoStock*1 + $this->request->getData()['detallecompras'][$kdv]['cantidad']*1;

                          $query = $productos->query();
                          $query->update()
                              ->set(['stock' => $nroStock])
                              ->where(['id' => $prodid])
                              ->execute();
                          $respuesta .=  "Stock Actualizado. ";    
                      }
                      
                  }
                  $response = $this->response;
                  $data=[
                      'result' => 'success',
                      'respuesta'=>$respuesta];
                  $response = $response->withType('application/json')
                  ->withStringBody(json_encode($data));
                  echo json_encode($data);
                  return $this->response;     
              }
              $respuesta = 'Error. La compra no pudo ser guardada.';
              $response = $this->response;
              $data=['result' => 'fail',
                      'response'=>$respuesta,
                      'data'=>$respuesta];
              echo json_encode($data);
              $response = $response->withType('application/json')
                  ->withStringBody(json_encode($data));
              return $this->response;        

      }
      $clientes = $this->Compras->Clientes->find('list', ['limit' => 200]);
      $puntodeventas = $this->Compras->Puntodeventas->find('list', ['limit' => 200]);
      $rubros = $this->Productos->Rubros->find('list', ['limit' => 200]);
      $users = $this->Compras->Users->find('list', ['limit' => 200]);
      

      $this->set(compact('compra','cliente','producto','rubros', 'clientes', 'puntodeventas', 'users'));

      $topcompra = $this->Compras->find('all',[
         'fields' => ['ultimacompra' => 'MAX(Compras.numero*1)'],
         'conditions'=>[
              'Compras.puntodeventa_id'=> $micaja['puntodeventa']['numero']
         ]
      ]); 
      $ultimacompra = iterator_to_array($topcompra);      
      $session = $this->request->getSession(); // less than 3.5
      // $session = $this->request->getSession(); // 3.5 or more
      $AuthUserId = $session->read('Auth.User')['id'];
      $AuthUserNombre = $session->read('Auth.User')['first_name']." ".$session->read('Auth.User')['last_name'];

      $this->set(compact('AuthUserId','AuthUserNombre','ultimacompra','ultimopago'));

      //Detalle de Compras
      $detallecompra = $this->Detallecompras->newEntity();
      $productos = $this->Detallecompras->Productos->find('list');
      $comprobantes = $this->Compras->Comprobantes->find('list');
      $this->set(compact('detallecompra','comprobantes','productos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Compra id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $compra = $this->Compras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $compra = $this->Compras->patchEntity($compra, $this->request->getData());
            if ($this->Compras->save($compra)) {
                $this->Flash->success(__('The compra has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The compra could not be saved. Please, try again.'));
        }
        $this->set(compact('compra'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Compra id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $compra = $this->Compras->get($id);
        if ($this->Compras->delete($compra)) {
            //vamos a buscar todos los detalles que tengan este id
             $conditionsDv = [
                'contain' => [],
                'conditions'=>[
                    'Detallecompras.compra_id'=>$id
                ]
            ];
            $detallecompras = $this->Compras->Detallecompras->find('all',$conditionsDv);
            $respuesta="";
            foreach ($detallecompras as $kdv => $detallecompra) {
                  //vamos a sumar a los stocks las cantidades de estos detalles
                  $productos = TableRegistry::get('Productos');
                  $prodid = $detallecompra['producto_id'];
                  $productoStock = $productos->get($prodid)->stock;

                  $nroStock = $productoStock*1 + $detallecompra['cantidad']*1;

                  $query = $productos->query();
                  $query->update()
                      ->set(['stock' => $nroStock])
                      ->where(['id' => $prodid])
                      ->execute();
                  $respuesta .=  "Stock Actualizado. ";   
                  //vamos a eliminar estos detalles
                  $dv = $this->Compras->Detallecompras->get($detallecompra['id']);
                  if ($this->Compras->delete($compra)) {
                      $respuesta .=  "Detalle de Compra eliminado.";   
                  }
            }
            //vamos a buscar todos los pagos que tengan este id
             $conditionsP = [
                'contain' => [],
                'conditions'=>[
                    'Pagos.compra_id'=>$id
                ]
            ];
            $pagos = $this->Compras->Pagos->find('all',$conditionsP);
            $respuesta="";
            foreach ($pagos as $kp => $pago) {
                  //vamos a eliminar estos detalles
                  $pag = $this->Compras->Pagos->get($pago['id']);
                  if ($this->Compras->Pagos->delete($pag)) {
                      $respuesta .=  "Pago de Compra eliminado.";   
                  }
            }
            $this->Flash->success(__('La venta se ha eliminado. '.$respuesta));
        } else {
            $this->Flash->error(__('The compra could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
