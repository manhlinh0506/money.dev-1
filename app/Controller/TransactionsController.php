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
    // value of flag
    const DELETE_FLAG = 0;
    //value default of parent_transaction
    const PARENT_TRANSACTION = null;

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
        if (!(count($this->Transaction->Category->Wallet->User->checkWallet($this->Auth->user('id'))) > 0)) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/add');
        }
        $current_wallet = $this->Transaction->Category->Wallet->getAllWallet($this->Auth->user('id'));
        $arr_category = $this->Transaction->Category->find('all', array(
            'conditions' => array(
                'Category.wallet_id' => $current_wallet[self::GET_ARRAY]['users']['current_wallet'])));
        $k = 0;

        $array_transaction = array();
        foreach ($arr_category as $category) {
            $array_transaction[$k] = $category['Category']['id'];
            $k++;
        }
        $this->Paginator->settings = array(
            'conditions' => array('Transaction.category_id' => $array_transaction));
        $this->set('transactions', $this->Paginator->paginate());
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if (!(count($this->Transaction->Category->Wallet->User->checkWallet($this->Auth->user('id'))) > 0)) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/add');
        }
        if ($this->request->is('post')) {
            $this->Transaction->create();
            $this->Transaction->set($this->request->data);
            if ($this->Transaction->validates($this->Transaction->validate)) {
                $special = $this->Transaction->checkSpecial($this->request->data('category_id'));
                $transaction = array();
                $datetime = $this->request->data('Transaction')['date_of_execution'];
                $datetime = $datetime['year'] . '-' . $datetime['month'] . '-' . $datetime['day'];
                if ($special == null) {
                    //not special type
                    $transaction = array(
                        'name' => $this->request->data('name'),
                        'transaction_value' => $this->request->data('transaction_value'),
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s'),
                        'category_id' => $this->request->data('category_id'),
                        'delete_flag' => self::DELETE_FLAG,
                        'date_of_execution' => $datetime
                    );
                } else {
                    //special type
                    if ($this->request->data('published') == 0) {
                        $transaction = array(
                            'name' => $this->request->data('name'),
                            'transaction_value' => $this->request->data('transaction_value'),
                            'created' => date('Y-m-d H:i:s'),
                            'modified' => date('Y-m-d H:i:s'),
                            'category_id' => $this->request->data('category_id'),
                            'delete_flag' => self::DELETE_FLAG,
                            'date_of_execution' => $datetime
                        );
                    } else {
                        $transaction = array(
                            'name' => $this->request->data('name'),
                            'transaction_value' => $this->request->data('transaction_value'),
                            'created' => date('Y-m-d H:i:s'),
                            'modified' => date('Y-m-d H:i:s'),
                            'category_id' => $this->request->data('category_id'),
                            'delete_flag' => self::DELETE_FLAG,
                            'date_of_execution' => $datetime,
                            'parent_transaction' => '' . $this->request->data('loan'),
                        );
                    }
                }
                if ($this->Transaction->save($transaction)) {
                    $this->Session->setFlash(__('The transaction has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
                }
            }
        }
        $categories = $this->Transaction->getCategory($this->Auth->user('id'));
        $data = $this->Transaction->getFirstCategory($this->Auth->user('id'), key($categories));
        $trans = array();
        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $trans[$i] = $data[$i]['transactions'];
            }
        }

        $this->set(compact(array('categories', 'trans')));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!(count($this->Transaction->Category->Wallet->User->checkWallet($this->Auth->user('id'))) > 0)) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/add');
        }
        if (!$this->Transaction->exists($id)) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $special = $this->Transaction->checkSpecial($this->request->data('category_id'));
            $datetime = $this->request->data('Transaction')['date_of_execution'];
            $updateTransaction = false;
            $datetime = "'".$datetime['year'] . '-' . $datetime['month'] . '-' . $datetime['day']."'";
            if ($special == null) {
                $updateTransaction = $this->Transaction->updateAll(
                        array('name' => "'" . $this->request->data('name') . "'",
                    'transaction_value' => $this->request->data('transaction_value'),
                    'modified' => "'" . date('Y-m-d H:i:s') . "'",
                    'category_id' => $this->request->data('category_id'),
                    'date_of_execution' => $datetime,
                    'parent_transaction' => self::PARENT_TRANSACTION), array('Transaction.id' => $this->request->data('id'))
                );
            } else {
                if ($this->request->data('published') == 0) {
                    $updateTransaction = $this->Transaction->updateAll(
                            array('name' => "'" . $this->request->data('name') . "'",
                        'transaction_value' => $this->request->data('transaction_value'),
                        'modified' => "'" . date('Y-m-d H:i:s') . "'",
                        'category_id' => $this->request->data('category_id'),
                        'date_of_execution' => $datetime,
                        'parent_transaction' => self::PARENT_TRANSACTION), array('Transaction.id' => $this->request->data('id'))
                    );
                } else {
                    $updateTransaction = $this->Transaction->updateAll(
                            array('name' => "'" . $this->request->data('name') . "'",
                        'transaction_value' => $this->request->data('transaction_value'),
                        'modified' => "'" . date('Y-m-d H:i:s') . "'",
                        'category_id' => $this->request->data('category_id'),
                        'date_of_execution' =>  $datetime,
                        'parent_transaction' => $this->request->data('loan')), array('Transaction.id' => $this->request->data('id'))
                    );
                }
            }
            if ($updateTransaction) {
                $this->Session->setFlash(__('The transaction has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
            $this->request->data = $this->Transaction->find('first', $options);
        }
        $categories = $this->Transaction->getCategory($this->Auth->user('id'));
        $data = $this->Transaction->getFirstCategoryToEdit($this->Auth->user('id'), $this->request->data('Transaction')['category_id'], $id);
        $trans = array();
        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $trans[$i] = $data[$i]['transactions'];
            }
        }
        $this->set(compact(array('categories', 'trans', 'parent_transaction')));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!(count($this->Transaction->Category->Wallet->User->checkWallet($this->Auth->user('id'))) > 0)) {
            $this->Session->setFlash('Your need to create wallet first.');
            $this->redirect('/wallets/add');
        }
        $this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        $this->request->allowMethod('post', 'delete');
        $child_transactions = $this->Transaction->getChild_transaction($id);
        $ds = $this->Transaction->getDataSource();
        $ds->begin();
        try {
            foreach ($child_transactions as $key => $transaction) {
                $this->Transaction->delete($key);
            }
            $this->Transaction->delete($id);
            $ds->commit();
            $this->Session->setFlash(__('The transaction has been deleted.'));
        } catch (Exception $e) {
            $ds->rollback();
            $this->Session->setFlash(__('The transaction could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * getCheckbox method
     *
     * @throws NotFoundException
     * @param 
     * @return void
     */
    public function getcheckbox() {
        $this->autoRender = false;
        $checkbox_value = $this->request->data['text'];
        $transaction_id = $this->request->data['id'];
        $data = $this->Transaction->getValue($checkbox_value);
        $details = '';
        if ($data['Category']['special_id'] == null) {
            $details = null;
        } else {
            if ($data['Category']['special_id'] == 1) {
                $details = $this->Transaction->getLoan($this->Auth->user('id'), $transaction_id);
            } else {
                $details = $this->Transaction->getBorrowing($this->Auth->user('id'), $transaction_id);
            }
        }

        echo json_encode($details);
    }

    /**
     * getCheckbox method
     *
     * @throws NotFoundException
     * @param 
     * @return void
     */
    public function getcheckboxadd() {
        $this->autoRender = false;
        $checkbox_value = $this->request->data['text'];
        $data = $this->Transaction->getValue($checkbox_value);
        $details = '';
        if ($data['Category']['special_id'] == null) {
            $details = null;
        } else {
            if ($data['Category']['special_id'] == 1) {
                $details = $this->Transaction->getLoanAdd($this->Auth->user('id'));
            } else {
                $details = $this->Transaction->getBorrowingAdd($this->Auth->user('id'));
            }
        }

        echo json_encode($details);
    }

}
