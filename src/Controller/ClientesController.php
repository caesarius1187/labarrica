<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Http\Response;

/**
 * Clientes Controller
 *
 * @property \App\Model\Table\ClientesTable $Clientes
 *
 * @method \App\Model\Entity\Cliente[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $clientes =$this->Clientes->find('all');
        $this->set(compact('clientes'));
        
        $micliente = $this->Clientes->newEntity();
        $this->set(compact('micliente'));
    }

    /**
     * View method
     *
     * @param string|null $id Cliente id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($this->viewVars['userfiscal']){
            $this->Flash->error(__('Error al intentar abrir la vista. Por favor intentelo de nuevo mas tarde.'));
            return $this->redirect(['action' => 'index']);
        }
        $cliente = $this->Clientes->get($id, [
            'contain' => ['Ventas','Pagos','Compras']
        ]);

        $this->set('cliente', $cliente);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cliente = $this->Clientes->newEntity();
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $clientesTable = TableRegistry::get('Clientes');
           // New entity with nested associations
            $entity = $clientesTable->newEntity($this->request->getData());
            $respuesta = "";
            if ($clientesTable->save($entity)) {
                // The $article entity contains the id now
                $id = $entity->id;
                $respuesta .=  "El cliente ha sido guardado. ";
                $response = $this->response;
                $data=[
                    'result' => 'success',
                    'respuesta'=>$respuesta,
                    'cliente'=>$entity,
                ];
                $response = $response->withType('application/json')
                ->withStringBody(json_encode($data));
                echo json_encode($data);
                return $this->response;     
            }
            $respuesta = 'Error. El cliente NO ha sido guardado.';
            $response = $this->response;
            $data=['result' => 'fail',
                    'response'=>$respuesta,
                    'cliente'=>$entity];
            echo json_encode($data);
            $response = $response->withType('application/json')
                ->withStringBody(json_encode($data));
            return $this->response;        
        }
        $this->set(compact('cliente'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cliente id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cliente = $this->Clientes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->getData());
            if ($this->Clientes->save($cliente)) {
                $this->Flash->success(__('The cliente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cliente could not be saved. Please, try again.'));
        }
        $this->set(compact('cliente'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cliente id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cliente = $this->Clientes->get($id);
        if ($this->Clientes->delete($cliente)) {
            $this->Flash->success(__('The cliente has been deleted.'));
        } else {
            $this->Flash->error(__('The cliente could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
