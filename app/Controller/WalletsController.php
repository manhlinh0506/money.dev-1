<?php

App::uses('AppController', 'Controller');

/**
 * Wallets Controller
 *
 * @property Wallet $Wallet
 * @property PaginatorComponent $Paginator
 */
class WalletsController extends AppController {

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
        $current_wallet = $this->Wallet->User->find('first', array(
            'fields' => 'current_wallet',
            'conditions' => array('User.id' => $this->Auth->user('id'))
        ));
        $this->Session->write('Current_Wallet', $current_wallet['User']['current_wallet']);
        $this->Paginator->settings = array(
            'conditions' => array('Wallet.user_id' => $this->Auth->user('id')));
        $this->set('wallets', $this->Paginator->paginate('Wallet'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
//    public function view($id = null) {
//        if (!$this->Wallet->exists($id)) {
//            throw new NotFoundException(__('Invalid wallet'));
//        }
//        $options = array('conditions' => array('Wallet.' . $this->Wallet->primaryKey => $id));
//        $this->set('wallet', $this->Wallet->find('first', $options));
//    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Wallet->set($this->request->data);
            if ($this->Wallet->validates($this->Wallet->validate)) {
                $wallet = array(
                    'name' => $this->request->data('name'),
                    'currency_id' => $this->request->data('currency_id'),
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                    'user_id' => $this->Auth->user('id'),
                    'balance' => $this->request->data('balance')
                );
                if ($this->Wallet->save($wallet)) {
                    $this->Session->setFlash(__('The wallet has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The wallet could not be saved. Please, try again.'));
                }
            }
        }
        $currencies = $this->Wallet->Currency->find('list');
        $this->set(compact('currencies'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Wallet->exists($id)) {
            throw new NotFoundException(__('Invalid wallet'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->Wallet->set($this->request->data);
            if ($this->Wallet->validates($this->Wallet->validate)) {
                $updateWallet = $this->Wallet->updateAll(
                        array('Wallet.name' => "'" . $this->request->data('name') . "'",
                    'Wallet.currency_id' => $this->request->data('currency_id'),
                    'Wallet.modified' => "'" . date('Y-m-d H:i:s') . "'",
                    'Wallet.balance' => $this->request->data('balance')), array('Wallet.id' => $this->request->data('id'))
                );
                if ($updateWallet) {
                    $this->Session->setFlash(__('The wallet has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The wallet could not be saved. Please, try again.'));
                }
            }
        } else {
            $options = array('conditions' => array('Wallet.' . $this->Wallet->primaryKey => $id));
            $this->request->data = $this->Wallet->find('first', $options);
        }
        $currencies = $this->Wallet->Currency->find('list');
        $this->set(compact('currencies'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Wallet->id = $id;
        if (!$this->Wallet->exists()) {
            throw new NotFoundException(__('Invalid wallet'));
        }
        $this->request->allowMethod('post', 'delete');
        $list_delete = $this->Wallet->deleteWallet($id);
        if ($this->deleteAllInfoOfWallet($list_delete, $id)) {
            $this->Session->setFlash(__('The wallet has been deleted.'));
        } else {
            $this->Session->setFlash(__('The wallet could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * changeWallet method
     *
     * @throws NotFoundException
     * @param  $id
     * @return 
     */
    public function changeWallet($id = null) {
        if (!$this->Wallet->exists($id)) {
            throw new NotFoundException(__('Invalid wallet'));
        }
        $changeWallet = $this->Wallet->User->updateAll(
                array('User.current_wallet' => $id), array('User.id' => $this->Auth->user('id'))
        );
        if ($changeWallet) {
            $userInfo = $this->Wallet->User->getUserInfo($this->Auth->user('id'));
            $this->Session->setFlash(__('The current wallet is changed.'));
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('The current wallet is not changed. Please try again.'));
        }
    }

    /**
     * tranfer method
     *
     * @throws NotFoundException
     * @param  $id
     * @return 
     */
    public function transfer($id = null) {
        if (!$this->Wallet->exists($id)) {
            throw new NotFoundException(__('Invalid wallet'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $current_currency = $this->Wallet->find('first', array(
                'conditions' => array(
                    'Wallet.id' => $id,
                )
                    )
            );
            $current_currency['Currency']['rate'];
            $tranfer_currency = $this->Wallet->find('first', array(
                'conditions' => array(
                    'Wallet.id' => $this->request->data('Wallet')['To'],
                )
                    )
            );
            $ds = $this->Wallet->getDataSource();
            $ds->begin();
            try {
                if ($current_currency['Currency']['name'] == $tranfer_currency['Currency']['name']) {
                    $tranfer_money = $this->request->data('balance');
                    $this->Wallet->updateAll(array(
                        'Wallet.modified' => "'" . date('Y-m-d H:i:s') . "'",
                        'Wallet.balance' => $current_currency['Wallet']['balance'] - $tranfer_money), array('Wallet.id' => $id)
                    );
                    $this->Wallet->updateAll(array(
                        'Wallet.modified' => "'" . date('Y-m-d H:i:s') . "'",
                        'Wallet.balance' => $tranfer_currency['Wallet']['balance'] + $tranfer_money), array('Wallet.id' => $this->request->data('Wallet')['To'])
                    );
                } else {
                    $tranfer_money = $this->request->data('balance') / $current_currency['Currency']['rate'] * $tranfer_currency['Currency']['rate'];
                    $this->Wallet->updateAll(array(
                        'Wallet.modified' => "'" . date('Y-m-d H:i:s') . "'",
                        'Wallet.balance' => $current_currency['Wallet']['balance'] - $this->request->data('balance')), array('Wallet.id' => $id)
                    );
                    $this->Wallet->updateAll(array(
                        'Wallet.modified' => "'" . date('Y-m-d H:i:s') . "'",
                        'Wallet.balance' => $tranfer_currency['Wallet']['balance'] + $tranfer_money), array('Wallet.id' => $this->request->data('Wallet')['To'])
                    );
                }
                $ds->commit();
                $this->Session->setFlash(__('The transaction is successful.'));
                return $this->redirect(array('action' => 'index'));
            } catch (Exception $e) {
                $ds->rollback();
                $this->Session->setFlash(__('The transaction is error. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Wallet.' . $this->Wallet->primaryKey => $id));
            $this->request->data = $this->Wallet->find('first', $options);
        }
        $currencies = $this->Wallet->Currency->find('list');
        $wallets = $this->Wallet->find('list', array(
            'conditions' => array(
                'Wallet.user_id' => $this->Auth->user('id'),
                'Wallet.id !=' => $id,
            )
                )
        );
        $this->set(compact('currencies', 'wallets'));
    }

    /**
     * deleteWallet method
     * define all transactions of categories of wallet with wallet id = $id
     * @throws NotFoundException
     * @param string $id
     * @return array
     */
    function deleteAllInfoOfWallet($list_info, $id) 
    {
        $ds = $this->Wallet->getDataSource();
        $ds->begin();
        $i = 0;
        $transation_list = 0;
        if (count($list_info) > 0) {
            try {
                foreach ($list_info as $info) {
                    if (count($info[$transation_list]) > 1) {
                        foreach ($info[$transation_list] as $transaction) {
                            $this->Wallet->Category->Transaction->delete($transaction['Transaction']['id']);
                        }
                    } else {
                        if (count($info[$transation_list]) > 0) {
                            $this->Wallet->Category->Transaction->delete($info[$transation_list][$transation_list]['Transaction']['id']);
                        }
                    }
                    $this->Wallet->Category->delete($info['Category_id']);
                    $i++;
                }
            } catch (Exception $deleteCategory) {
                $ds->rollback();
                return false;
            }
        }
        try {
            $this->Wallet->delete($id);
            $ds->commit();
            return true;
        } catch (Exception $deleteWallet) {
            $ds->rollback();
            return false;
        }
    }
}
