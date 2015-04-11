<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class CategoriesController extends AppController {

    // delete flag of category
    const DEFAULT_0 = 0;
    // default special_id
    const SPECIAL_ID = null;

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
        if (!(count($this->Category->Wallet->User->checkWallet($this->Auth->user('id'))) > 0)) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/add');
        }
        $ids = $this->Category->Wallet->getAllWallet($this->Auth->user('id'));
        $this->Paginator->settings = array(
            'conditions' => array('Category.wallet_id' => $ids[self::DEFAULT_0]['users']['current_wallet']));
        $this->set('categories', $this->Paginator->paginate());
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if (!(count($this->Category->Wallet->User->checkWallet($this->Auth->user('id'))) > 0)) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/add');
        }
        if ($this->request->is('post')) {
            $this->Category->create();
            $this->Category->set($this->request->data);
            if ($this->Category->validates($this->Category->validate)) {
                $category = array(
                    'name' => $this->request->data('name'),
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                    'delete_flag' => self::DEFAULT_0,
                    'wallet_id' => $this->request->data('wallet_id'),
                    'typename_id' => $this->request->data('typename_id')
                );
                if ($this->request->data('published') == 1) {
                    $category['special_id'] = $this->request->data('special_id');
                } else {
                    $category['special_id'] = self::SPECIAL_ID;
                }
                if ($this->Category->save($category)) {
                    $this->Category->Wallet->changeCurrent($this->request->data('wallet_id'), $this->Auth->user('id'));
                    $this->Session->setFlash(__('The category has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
                }
            }
        }
        $wallets = $this->Category->Wallet->find('list', array(
            'conditions' => array(
                'Wallet.user_id' => $this->Auth->user('id'))));
        $current_wallet = $this->Category->Wallet->getAllWallet($this->Auth->user('id'));
        $typenames = $this->Category->Typename->find('list');
        $specials = $this->Category->Special->find('list', array(
            'conditions' => array('name' => 'loan')));
        $this->set(compact('wallets', 'typenames', 'specials', 'current_wallet'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!(count($this->Category->Wallet->User->checkWallet($this->Auth->user('id'))) > 0)) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/add');
        }
        if ($this->Category->getDeleteFlag($id) == 1) {
            $this->Session->setFlash('Can not edit default category');
            $this->redirect('/categories/');
        }
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is(array('post', 'put'))) {

            $this->Category->set($this->request->data);
            if ($this->Category->validates($this->Category->validate)) {
                $updateCategory = false;
                if ($this->request->data('published') == 1) {
                    $updateCategory = $this->Category->updateAll(
                            array('Category.name' => "'" . $this->request->data('name') . "'",
                        'Category.modified' => "'" . date('Y-m-d H:i:s') . "'",
                        'Category.wallet_id' => $this->request->data('wallet_id'),
                        'Category.typename_id' => $this->request->data('typename_id'),
                        'Category.special_id' => $this->request->data('special_id')), array(
                        'Category.id' => $this->request->data('id'))
                    );
                } else {
                    $updateCategory = $this->Category->updateAll(
                            array('Category.name' => "'" . $this->request->data('name') . "'",
                        'Category.modified' => "'" . date('Y-m-d H:i:s') . "'",
                        'Category.wallet_id' => $this->request->data('wallet_id'),
                        'Category.typename_id' => $this->request->data('typename_id'),
                        'Category.special_id' => self::SPECIAL_ID), array(
                        'Category.id' => $this->request->data('id'))
                    );
                }
                if ($updateCategory) {
                    $this->Session->setFlash(__('The category has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
                }
            }
        } else {
            $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
            $this->request->data = $this->Category->find('first', $options);
        }
        $wallets = $this->Category->Wallet->find('list', array(
            'conditions' => array(
                'Wallet.user_id' => $this->Auth->user('id'))));
        $typenames = $this->Category->Typename->find('list');
        $specials = $this->Category->Special->find('list', array(
            'conditions' => array(
                'Special.id' => $this->request->data('Category')['special_id'])));
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
        if (!(count($this->Category->Wallet->User->checkWallet($this->Auth->user('id'))) > 0)) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/add');
        }
        if ($this->Category->getDeleteFlag($id) == 1) {
            $this->Session->setFlash('Can not delete default category');
            $this->redirect('/categories/');
        }
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->allowMethod('post', 'delete');
        $list_transaction = $this->Category->getTransaction($id);
        if ($this->deleteCategory($list_transaction, $id)) {
            $this->Session->setFlash(__('The category has been deleted.'));
        } else {
            $this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * show method
     * show transactions by category
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function show($id = null) {
        if (!$this->Category->Wallet->User->checkWallet($this->Auth->user('id'))) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/');
        }
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate(
                'Transaction', array('Transaction.category_id' => $id)
        );

        $this->set('transactions', $data);
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
        if (count($list_transaction) > 0) {
            try {
                foreach ($list_transaction as $transaction) {
                    $this->Category->Transaction->delete($transaction['Transaction']['id']);
                }
            } catch (Exception $deleteTransaction) {
                $ds->rollback();
                return false;
            }
        }
        try {
            $this->Category->delete($id);
            $ds->commit();
            return true;
        } catch (Exception $deleteCategory) {
            $ds->rollback();
            return false;
        }
    }

    /**
     * getSpecial method
     * get special_type of category
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function getSpecial() {
        $this->autoRender = false;
        $typename = $this->request->data['type'];
        $data = $this->Category->getSpecial($typename);
        echo json_encode($data);
    }

}
