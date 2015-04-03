<?php
App::uses('AppController', 'Controller');
/**
 * Typenames Controller
 *
 * @property Typename $Typename
 * @property PaginatorComponent $Paginator
 */
class TypenamesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typename->recursive = 0;
		$this->set('typenames', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typename->exists($id)) {
			throw new NotFoundException(__('Invalid typename'));
		}
		$options = array('conditions' => array('Typename.' . $this->Typename->primaryKey => $id));
		$this->set('typename', $this->Typename->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typename->create();
			if ($this->Typename->save($this->request->data)) {
				$this->Session->setFlash(__('The typename has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typename could not be saved. Please, try again.'));
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
		if (!$this->Typename->exists($id)) {
			throw new NotFoundException(__('Invalid typename'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Typename->save($this->request->data)) {
				$this->Session->setFlash(__('The typename has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typename could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typename.' . $this->Typename->primaryKey => $id));
			$this->request->data = $this->Typename->find('first', $options);
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
		$this->Typename->id = $id;
		if (!$this->Typename->exists()) {
			throw new NotFoundException(__('Invalid typename'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Typename->delete()) {
			$this->Session->setFlash(__('The typename has been deleted.'));
		} else {
			$this->Session->setFlash(__('The typename could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
