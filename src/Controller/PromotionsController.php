<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Filesystem\File;

/**
 * Promotions Controller
 *
 * @property \App\Model\Table\PromotionsTable $Promotions
 *
 * @method \App\Model\Entity\Promotion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PromotionsController extends AppController
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
        $this->loadModel('Productos');
        $conditions = [
            'contain' => ['Rubros','Promotions'],
            'conditions' => [
                'Productos.promocion = 1'
            ]
        ];
        $productos = $this->Productos->find('all',$conditions);
        $this->set(compact('productos'));
    }

    public function resumenpromociones()
    {
        ini_set('memory_limit', '256M');
        $conditions = [
            'contain' => ['Productos','Productospromocion'],
            'conditions' => [
                //'Productos.promocion = 0'
            ]
        ];
        $promotions = $this->Promotions->find('all',$conditions);
        $this->set(compact('promotions'));
    }
    public function importar($cliid=null,$periodo=null){
        $this->loadModel('Filespromociones');
        $uploadData = '';
        if ($this->request->is('post')) {
            if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                $uploadPath = 'promocionesimportadas/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Filespromociones->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
                    if ($this->Filespromociones->save($uploadData)) {
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
        
        $files = $this->Filespromociones->find('all', ['order' => ['Filespromociones.created' => 'DESC']]);
        $filesRowNum = $files->count();
        $this->set('files',$files);
        $this->set('filesRowNum',$filesRowNum);
    }
    public function procesar($fileId){
        $this->loadModel('Productos');
        $this->loadModel('Filespromociones');
        $this->autoRender = false;
        $file = $this->Filespromociones->get($fileId, [
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
                debug($count);
                $codigopromocion =  $datos[1];
                $codigoproducto =  $datos[3];

                $prodProm=$this->Productos->find('all', ['conditions' => ['codigo'=>$codigopromocion]])->first();
                $prodIng=$this->Productos->find('all', ['conditions' => ['codigo'=>$codigoproducto]])->first();

                debug("promocion actualizada: ".$datos[0]." -- codigo: ".$datos[1]." producto actualizado: ".$datos[2]." -- codigo: ".$datos[3]);
                $query = $this->Promotions->find('all',['conditions'=>['producto_id'=>$prodProm->id,'productopromocion_id'=>$prodIng->id]]);
                foreach($query as $prom){
                    //precio unidad
                    
                    $costo =  str_replace(",", ".", "$datos[4]")*1;
                    $ganancia = round(str_replace(",", ".", "$datos[5]")*1);
                    $precio = str_replace(",", ".", "$datos[6]")*1;
                    $cantidad = str_replace(",", ".", "$datos[7]")*1;


                    //precio unidad
                    $prom->costo = $costo;
                    $prom->ganancia = $ganancia;
                    $prom->precio = $precio;
                    $prom->cantidad = $cantidad;

                    $this->Promotions->save($prom);
                }
            }
           
        }
        fclose($handler);

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
    /**
     * View method
     *
     * @param string|null $id Promotion id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Productos');
        $producto = $this->Productos->get($id, [
            'contain' => ['Promotions'=>['Productos']]
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
        $this->loadModel('Productos');
        $producto = $this->Productos->newEntity();

        if ($this->request->is('post')) {
            $producto = $this->Productos->patchEntity($producto, $this->request->getData(),['associated' => ['Promotions']]);
            $producto->promotions = $this->request->getData()['promotions'];
            if ($this->Productos->save($producto)) {
                $id = $producto->id;
                //guardamos los detalles de ventas
                foreach ($this->request->getData()['promotions'] as $kp => $promotion) {
                    $promotionTable = TableRegistry::get('Promotions');
                    // New entity with nested associations
                    $entityPromotion = $promotionTable->newEntity($this->request->getData()['promotions'][$kp], [
                    ]);
                    $entityPromotion->producto_id = $id;
                    if ($promotionTable->save($entityPromotion)) {
                    }
                }
                $this->Flash->success(__('Se ha guardado la promocion.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Error. No se ha guardado la promocion. Por favor intente de nuevo mas tarde.'));
        }
        $productos = $this->Promotions->Productos->find('list', [
            'conditions'=>['Productos.promocion'=>0]
        ]);
        $this->set(compact('promotion', 'productos'));
        $rubros = $this->Productos->Rubros->find('list', []);
        $this->set(compact('producto', 'rubros'));
        $topproducto = $this->Productos->find('all',[
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
     * @param string|null $id Promotion id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Productos');
        $producto = $this->Productos->get($id, [
            'contain' => ['Promotions'=>['Productos']]
        ]);
      
        if ($this->request->is('post')) {
            $producto = $this->Productos->patchEntity($producto, $this->request->getData(),['associated' => ['Promotions']]);
            $producto->promotions = $this->request->getData()['promotions'];
            if ($this->Productos->save($producto)) {
                $id = $producto->id;
                //guardamos los detalles de ventas

                foreach ($this->request->getData()['promotions'] as $kp => $promotion) {
                    if($promotion['id']){
                      $mypromotion = $this->Promotions->get($promotion['id'], [
                        'contain' => ['Productos']
                      ]);
                      $mypromotion = $this->Promotions->patchEntity($mypromotion, $promotion,['associated' => ['Productos']]);
                      $mypromotion->producto_id = $id;
                    }else{
                      $mypromotion = $this->Promotions->newEntity($promotion,['associated' => ['Productos']]);
                      $mypromotion->producto_id = $id;
                    }
                    if ($this->Promotions->save($mypromotion)) {
                    }else{
                    }
                }
                $this->Flash->success(__('Se ha modificado la promocion.'));
                return $this->redirect(['action' => 'index']);
            }else{
                die($this->request->getData());
            }
            $this->Flash->error(__('Error. No se ha modificado la promocion. Por favor intente de nuevo mas tarde.'));
        }else{
        }
        $productos = $this->Promotions->Productos->find('list', []);
        $this->set(compact('promotion', 'productos'));
        $rubros = $this->Productos->Rubros->find('list', []);
        $this->set(compact('producto', 'rubros'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Promotion id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['ajax','post', 'delete']);
        $this->loadModel('Productos');
        $this->Promotions->deleteAll(['producto_id' => $id]);
        if ( $this->Productos->deleteAll(['id' => $id])) {
            $this->Flash->success(__('Promocion eliminada. '));
        } else {
            $this->Flash->error(__('no se ha podido eliminar la promocion'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
