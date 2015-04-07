<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class CategoriesController extends AppController {

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
        $this->Category->recursive = 0;
        $this->set('categories', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
        $this->set('category', $this->Category->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        }
        $wallets = $this->Category->Wallet->find('list');
        $typenames = $this->Category->Typename->find('list');
        $specials = $this->Category->Special->find('list');
        $this->set(compact('wallets', 'typenames', 'specials'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
            $this->request->data = $this->Category->find('first', $options);
        }
        $wallets = $this->Category->Wallet->find('list');
        $typenames = $this->Category->Typename->find('list');
        $specials = $this->Category->Special->find('list');
        $this->set(compact('wallets', 'typenames', 'specials'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->allowMethod('post', 'delete');
        $list_transaction = $this->getTransaction($id);
        if ($this->deleteCategory($list_transaction, $id)) {
            $this->Session->setFlash(__('The category has been deleted.'));
        } else {
            $this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * deleteWallet method
     * define all transactions of category with category id = $id
     * @throws NotFoundException
     * @param string $id
     * @return array
     */
    public function getTransaction($id) {
        $list_transaction = $this->Category->Transaction->find('all', array(
            'fields' => array('Transaction.id'),
            'conditions' => array('category_id' => $id)
                )
        );
        return $list_transaction;
    }

    /**
     * deleteCategory method
     * delete all transactions of category with category id = $id
     * @throws NotFoundException
     * @param array $id
     * @return boolean
     */
    public function deleteCategory($list_transaction, $id) {
        $ds = $this->Category->getDataSource();
        $ds->begin();
        $flag_transaction = true;
        $flag_category = true;
        if (count($list_transaction) > 0) {
            foreach ($list_transaction as $transaction) {
                if ($this->Category->Transaction->delete($transaction['Transaction']['id'])) {
                    $flag_transaction = true;
                } else {
                    $flag_transaction = false;
                    break;
                }
            }
        }
        if ($this->Category->delete($id)) {
            $flag_category = true;
        } else {
            $flag_category = false;
        }
        if ($flag_transaction && $flag_category) {
            $ds->commit();
            return true;
        } else {
            $ds->rollback();
            return false;
        }
    }

}
