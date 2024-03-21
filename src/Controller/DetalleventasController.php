<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Detalleventas Controller
 *
 * @property \App\Model\Table\DetalleventasTable $Detalleventas
 *
 * @method \App\Model\Entity\Detalleventa[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DetalleventasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Productos']
        ];
        $detalleventas = $this->paginate($this->Detalleventas);

        $this->set(compact('detalleventas'));
    }

    /**
     * View method
     *
     * @param string|null $id Detalleventa id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $detalleventa = $this->Detalleventas->get($id, [
            'contain' => ['Productos']
        ]);

        $this->set('detalleventa', $detalleventa);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $detalleventa = $this->Detalleventas->newEntity();
        if ($this->request->is('post')) {
            $detalleventa = $this->Detalleventas->patchEntity($detalleventa, $this->request->getData());
            if ($this->Detalleventas->save($detalleventa)) {
                $this->Flash->success(__('The detalleventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The detalleventa could not be saved. Please, try again.'));
        }
        $productos = $this->Detalleventas->Productos->find('list');
        $this->set(compact('detalleventa', 'productos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Detalleventa id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $detalleventa = $this->Detalleventas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $detalleventa = $this->Detalleventas->patchEntity($detalleventa, $this->request->getData());
            if ($this->Detalleventas->save($detalleventa)) {
                $this->Flash->success(__('The detalleventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The detalleventa could not be saved. Please, try again.'));
        }
        $productos = $this->Detalleventas->Productos->find('list', ['limit' => 200]);
        $this->set(compact('detalleventa', 'productos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Detalleventa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $detalleventa = $this->Detalleventas->get($id);
        if ($this->Detalleventas->delete($detalleventa)) {
            $this->Flash->success(__('The detalleventa has been deleted.'));
        } else {
            $this->Flash->error(__('The detalleventa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
