<?php
App::uses('AppController', 'Controller');
/**
 * Comprobantesasociados Controller
 *
 * @property Comprobantesasociado $Comprobantesasociado
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ComprobantesasociadosController extends AppController {

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
		$this->Comprobantesasociado->recursive = 0;
		$this->set('comprobantesasociados', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Comprobantesasociado->exists($id)) {
			throw new NotFoundException(__('Invalid comprobantesasociado'));
		}
		$options = array('conditions' => array('Comprobantesasociado.' . $this->Comprobantesasociado->primaryKey => $id));
		$this->set('comprobantesasociado', $this->Comprobantesasociado->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Comprobantesasociado->create();
			if ($this->Comprobantesasociado->save($this->request->data)) {
				$this->Session->setFlash(__('The comprobantesasociado has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comprobantesasociado could not be saved. Please, try again.'));
			}
		}
		$gestionventas = $this->Comprobantesasociado->Gestionventum->find('list');
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
		if (!$this->Comprobantesasociado->exists($id)) {
			throw new NotFoundException(__('Invalid comprobantesasociado'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Comprobantesasociado->save($this->request->data)) {
				$this->Session->setFlash(__('The comprobantesasociado has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comprobantesasociado could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Comprobantesasociado.' . $this->Comprobantesasociado->primaryKey => $id));
			$this->request->data = $this->Comprobantesasociado->find('first', $options);
		}
		$gestionventas = $this->Comprobantesasociado->Gestionventum->find('list');
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
		$this->Comprobantesasociado->id = $id;
		if (!$this->Comprobantesasociado->exists()) {
			throw new NotFoundException(__('Invalid comprobantesasociado'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Comprobantesasociado->delete()) {
			$this->Session->setFlash(__('The comprobantesasociado has been deleted.'));
		} else {
			$this->Session->setFlash(__('The comprobantesasociado could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
