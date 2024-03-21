<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Extracciones Controller
 *
 * @property \App\Model\Table\ExtraccionesTable $Extracciones
 *
 * @method \App\Model\Entity\Extraccione[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExtraccionesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $extracciones = $this->paginate($this->Extracciones);

        $this->set(compact('extracciones'));
    }

    /**
     * View method
     *
     * @param string|null $id Extraccione id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $extraccione = $this->Extracciones->get($id, [
            'contain' => []
        ]);

        $this->set('extraccione', $extraccione);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cajaAbierta = false;
        if(!empty($this->viewVars['cajasabiertas'])){
            foreach ($this->viewVars['cajasabiertas'] as $kc => $caja) {
              $idCaja = $caja['id'];
              $cajaAbierta = true;
            }
        }
        if(!$cajaAbierta){
            $this->Flash->error(__('Error. Para agregar una extraccion primero debe abrir una caja en un punto de venta.'));
            return $this->redirect(['action' => 'index']);
        }
        $extraccione = $this->Extracciones->newEntity();
        if ($this->request->is('post')) {
            $miExtraccion = $this->request->getData();
            $miExtraccion['fecha'] = date('Y-m-d h:m:s', strtotime( $miExtraccion['fecha']));
            $extraccione = $this->Extracciones->patchEntity($extraccione, $miExtraccion);
            if ($this->Extracciones->save($extraccione)) {
                $this->Flash->success(__('The extraccione has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The extraccione could not be saved. Please, try again.'));
        }
        $this->set(compact('extraccione'));
        $session = $this->request->getSession(); // less than 3.5
        // $session = $this->request->getSession(); // 3.5 or more
        $AuthUserId = $session->read('Auth.User')['id'];
        $AuthUserNombre = $session->read('Auth.User')['first_name']." ".$session->read('Auth.User')['last_name'];

        $this->set(compact('AuthUserId','AuthUserNombre'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Extraccione id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $extraccione = $this->Extracciones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $extraccione = $this->Extracciones->patchEntity($extraccione, $this->request->getData());
            if ($this->Extracciones->save($extraccione)) {
                $this->Flash->success(__('The extraccione has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The extraccione could not be saved. Please, try again.'));
        }
        $this->set(compact('extraccione'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Extraccione id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $extraccione = $this->Extracciones->get($id);
        if ($this->Extracciones->delete($extraccione)) {
            $this->Flash->success(__('The extraccione has been deleted.'));
        } else {
            $this->Flash->error(__('The extraccione could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
