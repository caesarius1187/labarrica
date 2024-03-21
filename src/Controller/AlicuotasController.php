<?php
App::uses('AppController', 'Controller');
/**
 * Alicuotas Controller
 *
 * @property Alicuota $Alicuota
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AlicuotasController extends AppController {

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
		$this->Alicuota->recursive = 0;
		$this->set('alicuotas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Alicuota->exists($id)) {
			throw new NotFoundException(__('Invalid alicuota'));
		}
		$options = array('conditions' => array('Alicuota.' . $this->Alicuota->primaryKey => $id));
		$this->set('alicuota', $this->Alicuota->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Alicuota->create();
			if ($this->Alicuota->save($this->request->data)) {
				$this->Session->setFlash(__('The alicuota has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The alicuota could not be saved. Please, try again.'));
			}
		}
		$gestionventas = $this->Alicuota->Gestionventum->find('list');
		$this->set(compact('gestionventas'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Alicuota->exists($id)) {
			throw new NotFoundException(__('Invalid alicuota'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Alicuota->save($this->request->data)) {
				$this->Session->setFlash(__('The alicuota has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The alicuota could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Alicuota.' . $this->Alicuota->primaryKey => $id));
			$this->request->data = $this->Alicuota->find('first', $options);
		}
		$gestionventas = $this->Alicuota->Gestionventum->find('list');
		$this->set(compact('gestionventas'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Alicuota->id = $id;
		if (!$this->Alicuota->exists()) {
			throw new NotFoundException(__('Invalid alicuota'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Alicuota->delete()) {
			$this->Session->setFlash(__('The alicuota has been deleted.'));
		} else {
			$this->Session->setFlash(__('The alicuota could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
