<?php

App::uses('AppController', 'Controller');

/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 * @property PaginatorComponent $Paginator
 */
class TransactionsController extends AppController {

    // get value of transaction array
    const GET_ARRAY = 0;
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
        $ids = $this->Transaction->Category->Wallet->getAllWallet($this->Auth->user('id'));
        $arr_wallet = array();
        $i = 0;
        foreach ($ids as $id) {
            $arr[$i] = $id['wallets']['id'];
            $i++;
        }
        $j = 0;
        $arr_category = array();
        foreach ($arr as $wallet) {
            $arr_category[$j] = $this->Transaction->Category->find('all',array(
                'conditions'=>array(
                    'Category.wallet_id'=>$wallet)));
            $j++;
        }
        $k = 0;
        $array_transaction = array();
        foreach ($arr_category[self::GET_ARRAY] as $category) {
            $array_transaction[$k] = $category['Category']['id'];
            $k++;
        }
        $this->Paginator->settings = array(
            'conditions' => array('Transaction.category_id' => $array_transaction));
        $this->set('transactions', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
//    public function view($id = null) {
//        if (!$this->Transaction->exists($id)) {
//            throw new NotFoundException(__('Invalid transaction'));
//        }
//        $options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
//        $this->set('transaction', $this->Transaction->find('first', $options));
//    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Transaction->create();
            if ($this->Transaction->save($this->request->data)) {
                $this->Session->setFlash(__('The transaction has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Transaction->Category->find('list');
        $this->set(compact('categories'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Transaction->exists($id)) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Transaction->save($this->request->data)) {
                $this->Session->setFlash(__('The transaction has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
            $this->request->data = $this->Transaction->find('first', $options);
        }
        $categories = $this->Transaction->Category->find('list');
        $this->set(compact('categories'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Transaction->delete()) {
            $this->Session->setFlash(__('The transaction has been deleted.'));
        } else {
            $this->Session->setFlash(__('The transaction could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
