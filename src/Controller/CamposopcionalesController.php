<?php
App::uses('AppController', 'Controller');
/**
 * Camposopcionales Controller
 *
 * @property Camposopcionale $Camposopcionale
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CamposopcionalesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Camposopcionale->recursive = 0;
		$this->set('camposopcionales', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Camposopcionale->exists($id)) {
			throw new NotFoundException(__('Invalid camposopcionale'));
		}
		$options = array('conditions' => array('Camposopcionale.' . $this->Camposopcionale->primaryKey => $id));
		$this->set('camposopcionale', $this->Camposopcionale->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Camposopcionale->create();
			if ($this->Camposopcionale->save($this->request->data)) {
				$this->Session->setFlash(__('The camposopcionale has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The camposopcionale could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Camposopcionale->exists($id)) {
			throw new NotFoundException(__('Invalid camposopcionale'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Camposopcionale->save($this->request->data)) {
				$this->Session->setFlash(__('The camposopcionale has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The camposopcionale could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Camposopcionale.' . $this->Camposopcionale->primaryKey => $id));
			$this->request->data = $this->Camposopcionale->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Camposopcionale->id = $id;
		if (!$this->Camposopcionale->exists()) {
			throw new NotFoundException(__('Invalid camposopcionale'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Camposopcionale->delete()) {
			$this->Session->setFlash(__('The camposopcionale has been deleted.'));
		} else {
			$this->Session->setFlash(__('The camposopcionale could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
