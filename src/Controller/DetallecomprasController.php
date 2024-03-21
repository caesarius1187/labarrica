<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Detallecompras Controller
 *
 * @property \App\Model\Table\DetallecomprasTable $Detallecompras
 *
 * @method \App\Model\Entity\Detallecompra[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DetallecomprasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Compras', 'Productos']
        ];
        $detallecompras = $this->paginate($this->Detallecompras);

        $this->set(compact('detallecompras'));
    }

    /**
     * View method
     *
     * @param string|null $id Detallecompra id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $detallecompra = $this->Detallecompras->get($id, [
            'contain' => ['Compras', 'Productos']
        ]);

        $this->set('detallecompra', $detallecompra);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $detallecompra = $this->Detallecompras->newEntity();
        if ($this->request->is('post')) {
            $detallecompra = $this->Detallecompras->patchEntity($detallecompra, $this->request->getData());
            if ($this->Detallecompras->save($detallecompra)) {
                $this->Flash->success(__('The detallecompra has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The detallecompra could not be saved. Please, try again.'));
        }
        $compras = $this->Detallecompras->Compras->find('list', ['limit' => 200]);
        $productos = $this->Detallecompras->Productos->find('list', ['limit' => 200]);
        $this->set(compact('detallecompra', 'compras', 'productos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Detallecompra id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $detallecompra = $this->Detallecompras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $detallecompra = $this->Detallecompras->patchEntity($detallecompra, $this->request->getData());
            if ($this->Detallecompras->save($detallecompra)) {
                $this->Flash->success(__('The detallecompra has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The detallecompra could not be saved. Please, try again.'));
        }
        $compras = $this->Detallecompras->Compras->find('list', ['limit' => 200]);
        $productos = $this->Detallecompras->Productos->find('list', ['limit' => 200]);
        $this->set(compact('detallecompra', 'compras', 'productos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Detallecompra id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $detallecompra = $this->Detallecompras->get($id);
        if ($this->Detallecompras->delete($detallecompra)) {
            $this->Flash->success(__('The detallecompra has been deleted.'));
        } else {
            $this->Flash->error(__('The detallecompra could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
