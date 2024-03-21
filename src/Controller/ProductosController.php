<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Filesystem\File;
/**
 * Productos Controller
 *
 * @property \App\Model\Table\ProductosTable $Productos
 *
 * @method \App\Model\Entity\Producto[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductosController extends AppController
{
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
        ini_set('memory_limit', '256M');
        $conditions = [
            'contain' => ['Rubros'],
            'conditions' => [
                'Productos.promocion = 0',
                'Productos.disabled = 0'
            ]
        ];
        $productos = $this->Productos->find('all',$conditions);
        $this->set(compact('productos'));
        $rubros = $this->Productos->Rubros->find('list', []);
        $this->set(compact('rubros'));
        $topproducto = $this->Productos->find('all',[
             'fields' => ['ultimoproducto' => 'MAX(Productos.codigo*1)'],
             'conditions'=>[
                  'Productos.codigo*1 < 10000'
             ]
          ]); 
          $topproducto = iterator_to_array($topproducto);
          $this->set('topproducto',$topproducto[0]['ultimoproducto']);
          $miproducto = $this->Productos->newEntity();
          $this->set('miproducto',$miproducto);

    }
    public function importar($cliid=null,$periodo=null){
        $this->loadModel('Files');
        $uploadData = '';
        if ($this->request->is('post')) {
            if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                $uploadPath = 'productosimportados/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
                    if ($this->Files->save($uploadData)) {
                        $this->Flash->success(__('File has been uploaded and inserted successfully.'));
                    }else{
                        $this->Flash->error(__('Unable to upload file, please try again.'));
                    }
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again.'));
                }
            }else{
                $this->Flash->error(__('Please choose a file to upload.'));
            }
            
        }
        $this->set('uploadData', $uploadData);
        
        $files = $this->Files->find('all', ['order' => ['Files.created' => 'DESC']]);
        $filesRowNum = $files->count();
        $this->set('files',$files);
        $this->set('filesRowNum',$filesRowNum);
    }
    public function procesar($fileId){
        $this->loadModel('Files');
        $this->autoRender = false;
        $file = $this->Files->get($fileId, [
            'contain' => []
        ]);

        $dirCompra = new File($file['path'].$file['name']);
        $dirCompra->open();
        $contents = $dirCompra->read();
        // $file->delete(); // I am deleting this file
        $handler = $dirCompra->handle;

        //$handle = fopen($file['path'].$file['name'], "r");
        $count=0;
        while ($data = fgets($handler)){
            $count++;
            if($count==1)continue;
            $fila1 = $data;
            $datos=explode(';', $fila1);
            if(isset($datos[7])){
                /*$conditions = [
                    'contain' => [],
                    'conditions' => [
                        'Productos.codigo = '.$data[7]
                    ]
                ];
                $producto = $this->Productos->find('first',$conditions);
                debug($producto);*/
                //debug($count);
                debug("producto actualizado: ".$datos[0]." -- codigo: ".$datos[7]);
                $query = $this->Productos->find('all',['conditions'=>['codigo*1'=>$datos[7]]]);
                foreach($query as $prod){
                    
                    //precio unidad
                    $costo =  str_replace(",", ".", "$datos[2]")*1;
                    $precio = str_replace(",", ".", "$datos[3]")*1;
                    $ganancia = round(str_replace(",", ".", "$datos[4]")*1);
                    $cantidad = $prod->cantpack;

                    //precio por pack preciopack0
                    $preciopackcalculado = str_replace(",", ".", "$datos[5]")*1;
                    $gananciapack = str_replace(",", ".", "$datos[6]")*1;
                    $preciopack = $costo*(1+($gananciapack/100));
                    
                    //lista precio 1
                    $ganancia1 = $prod->ganancia1;
                    $preciopack1 = round($costo*(1+($ganancia1/100)));
                    $preciopackcalculado1 = round($preciopack1*$cantidad);
                
                    //lista precio 2
                    $ganancia2 = $prod->ganancia2;
                    $preciopack2 = round($costo*(1+($ganancia2/100)));
                    $preciopackcalculado2 = round($preciopack2*$cantidad);
                
                    //lista precio 3
                    $ganancia3 = $prod->ganancia3;
                    $preciopack3 = round($costo*(1+($ganancia3/100)));
                    $preciopackcalculado3 = round($preciopack3*$cantidad);
                
                    //lista precio 4
                    $ganancia4 = $prod->ganancia4;
                    $preciopack4 = round($costo*(1+($ganancia4/100)));
                    $preciopackcalculado4 = round($preciopack4*$cantidad);


                    //precio unidad
                    $prod->precio = $precio;
                    $prod->costo = $costo;
                    $prod->ganancia = $ganancia;
                    $prod->precio = $precio;
                    //precio por pack preciopack0
                    $prod->preciopack = $preciopack;
                    $prod->gananciapack = $gananciapack;
                    $prod->preciopack0 = $preciopackcalculado;
                    //lista precio 1
                    $prod->preciomayor1 = $preciopack1;
                    $prod->preciopack1 = $preciopackcalculado1;
                    //lista precio 2
                    $prod->preciomayor2 = $preciopack2;
                    $prod->preciopack2 = $preciopackcalculado2;
                    //lista precio 3
                    $prod->preciomayor3 = $preciopack3;
                    $prod->preciopack3 = $preciopackcalculado3;
                    //lista precio 4
                    $prod->preciomayor4 = $preciopack4;
                    $prod->preciopack4 = $preciopackcalculado4;
                    
                    //$prod->stock = $datos[8]*1;

                    $this->Productos->save($prod);
                }
            }
           
        }
        fclose($handle);

        $data=['result' => 'fail',
                'response'=> 'cant files: '.$count,
                'cantFiles'=>$count,
                'error'=>0
            ];
        echo json_encode($data);
        $response = $this->response;
        $response = $response->withType('application/json')
            ->withStringBody(json_encode($data));
        return $this->response;     
    }
    public function resumenproductos()
    {
        ini_set('memory_limit', '256M');
        $conditions = [
            'contain' => ['Rubros'],
            'conditions' => [
                //'Productos.promocion = 0'
            ]
        ];
        $productos = $this->Productos->find('all',$conditions);
        $this->set(compact('productos'));
        $rubros = $this->Productos->Rubros->find('list', []);
        $this->set(compact('rubros'));
        $topproducto = $this->Productos->find('all',[
             'fields' => ['ultimoproducto' => 'MAX(Productos.codigo*1)'],
             'conditions'=>[
                  'Productos.codigo*1 < 10000'
             ]
          ]); 
          $topproducto = iterator_to_array($topproducto);
          $this->set('topproducto',$topproducto[0]['ultimoproducto']);
          $miproducto = $this->Productos->newEntity();
          $this->set('miproducto',$miproducto);

    }
     public function resumen()
    {
        ini_set('memory_limit', '1024M');
        $this->loadModel('Ventas');
        $fechaProductosfin = date('d-m-Y');
        $fechaProductosinicio = date('01-m-Y');
        if ($this->request->is('post')) {
                $fechaProductosfin = $this->request->getData()['fechahasta'];
                $fechaProductosinicio = $this->request->getData()['fechadesde'];
        }
        $fechaconsultainicio = date('Y-m-d',strtotime($fechaProductosinicio));
        $fechaconsultafin = date('Y-m-d',strtotime($fechaProductosfin));
        $conditions = [
            'contain' => [
                'Detalleventas'=>[
                    'Productos'=>[
                    ]
                ]
            ],
            'conditions'=>[
                'Ventas.presupuesto' => 0,
                'Ventas.created >= "'.$fechaconsultainicio.' 00:00:00"',
                'Ventas.created <= "'.$fechaconsultafin.' 23:59:59"',
            ]
        ];
        $ventasTable = TableRegistry::get('Ventas');
        $ventas = $ventasTable->find('all',$conditions)->toArray();
        $producto = $this->Productos->newEntity();
        $this->set(compact('fechaconsultainicio','fechaconsultafin','fechaProductosinicio','fechaProductosfin','producto','ventas'));
    }
    public function actualizarxrubro(){
        if ($this->request->is(['patch', 'post', 'put'])) {
            debug($this->request->getData());
            $rubro = $this->request->getData()['rubro_id'];
            $incremento = $this->request->getData()['incremento'];
            if($this->Productos->actualizarPrecioPorRubro($rubro,$incremento)){
                $this->Flash->success(__('Los productos han sido actualizados. El costo se incremento en un '.
                        $incremento
                    .' y se recalcularon precio de venta y precio de venta por stock'));
                return $this->redirect(['action' => 'index']);
            }
            
            
        }
        $producto = $this->Productos->newEntity();
        $rubros = $this->Productos->Rubros->find('list', ['limit' => 200]);
        $this->set(compact('producto', 'rubros'));
    }    
    /**
     * View method
     *
     * @param string|null $id Producto id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $producto = $this->Productos->get($id, [
            'contain' => ['Rubros', 'Detallecompras', 'Detalleventas']
        ]);

        $this->set('producto', $producto);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $producto = $this->Productos->newEntity();
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $productosTable = TableRegistry::get('Productos');
           // New entity with nested associations
            $entity = $productosTable->newEntity($this->request->getData());
            $respuesta = "";
            //no guardemos un codigo de producto repetido
            $exists = $productosTable->exists([
                'OR'=>[
                    'codigo' => $entity->codigo, 'codigopack' => $entity->codigo
                ]
            ]);
            if($exists){
                $respuesta = 'Error. El producto NO ha sido guardado, por que el codigo ya existe.';
                $response = $this->response;
                $data=['result' => 'fail',
                        'response'=>$respuesta,
                        'error'=>1,
                        'producto'=>$entity];
                echo json_encode($data);
                $response = $response->withType('application/json')
                    ->withStringBody(json_encode($data));
                return $this->response;        
            }
            if ($productosTable->save($entity)) {
                // The $article entity contains the id now
                $id = $entity->id;
                $respuesta .=  "El producto ha sido guardado. ";
                $response = $this->response;
                $data=[
                    'result' => 'success',
                    'respuesta'=>$respuesta,
                    'error'=>0,
                    'producto'=>$entity,
                ];
                $response = $response->withType('application/json')
                ->withStringBody(json_encode($data));
                echo json_encode($data);
                return $this->response;     
            }
            $respuesta = 'Error. El producto NO ha sido guardado.';
            $response = $this->response;
            $data=['result' => 'fail',
                    'response'=>$respuesta,
                    'error'=>2,
                    'producto'=>$entity];
            echo json_encode($data);
            $response = $response->withType('application/json')
                ->withStringBody(json_encode($data));
            return $this->response;        
        }
        $rubros = $this->Productos->Rubros->find('list', ['limit' => 200]);
        $this->set(compact('producto', 'rubros'));
    }   
    public function search()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->request->allowMethod(['ajax','post','get']);
        $this->viewBuilder()->setLayout('default');
   
        $keyword = $this->request->query('keyword');
        $query = $this->Productos->find('all',[
                'contain'=>[
                    'Promotions'=>['Productos']
                ],
                'conditions' => [
                    'OR'=>[
                        'codigo = '=>$keyword,
                        'codigopack = '=>$keyword,
                        'nombre = "'.$keyword.'"',
                    ]
                ],
                'order' => ['Productos.nombre'=>'DESC'],
                'limit' => 5
        ]);
        $this->set('productos', $query);

        $this->set('_serialize', ['productos']);

    }
    function autoComplete() {
        if ($this->request->is('ajax'))
        {
            $query = $this->params['url']['query'];
            $this->set('query', $query);

            $productos = $this->Productos->find('all', array(
                'conditions' => array(
                        'Productos.nombre LIKE' => '%'.$query.'%',
                    ),
                'fields' => array(
                    'Productos.nombre'
                    ),
                'limit' => 5
                ));

            $names = array();
            $id = array();
            foreach ($productos as $producto) {
                $fullName = $producto['Productos']['nombre'];
                array_push($names, $fullName);
                array_push($id, $producto['Productos']['id']);
            }
            $this->set('suggestions', $names);
            $this->set('data', $id);
            $this->set('_serialize', array('query', 'suggestions', 'data'));        
        }
    }
    /**
     * Edit method
     *
     * @param string|null $id Producto id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Promotions');
        $producto = $this->Productos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $producto = $this->Productos->patchEntity($producto, $this->request->getData());

            $productosTable = TableRegistry::get('Productos');
            $exists = $productosTable->exists([
                'OR'=>[
                    'codigo' => $producto->codigo, 'codigopack' => $producto->codigo
                ],
                 'id !=' => $producto->id
            ]);
            if($exists){
                $respuesta = 'Error. El producto NO ha sido guardado, por que el codigo ya existe.';
                 $this->Flash->error(__($respuesta));
                return $this->redirect(['action' => 'edit',$id]);
            }

            if ($this->Productos->save($producto)) {
                $this->Flash->success(__('El producto ha sido modificado.'));
                //actualizamos las promociones que apunten a este producto
                $this->Promotions->updateAll(
                    [  // fields
                        'costo' => $producto['costo'],
                        'precio = ROUND('.$producto['costo'].' * (1+ganancia/100))'
                    ],
                    [  // conditions
                        'Promotions.productopromocion_id' => $id
                    ]
                );
                //actualizamos el nuevo precio de la promocion
                $this->Productos->updatePrecioPromocion($id);
                return $this->redirect(['action' => 'edit',$id]);
            }
            $this->Flash->error(__('Error no se pudo modificar el producto. Por favor, intente de nuevo mas tarde.'));
        }
        $rubros = $this->Productos->Rubros->find('list', ['limit' => 200]);
        $this->set(compact('producto', 'rubros'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Producto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $producto = $this->Productos->get($id);
        if ($this->Productos->delete($producto)) {
            $this->Flash->success(__('The producto has been deleted.'));
        } else {
            $this->Flash->error(__('The producto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
