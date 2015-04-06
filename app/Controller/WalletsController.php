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
		$this->Wallet->recursive = 0;
		$this->set('wallets', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Wallet->exists($id)) {
			throw new NotFoundException(__('Invalid wallet'));
		}
		$options = array('conditions' => array('Wallet.' . $this->Wallet->primaryKey => $id));
		$this->set('wallet', $this->Wallet->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Wallet->create();
			if ($this->Wallet->save($this->request->data)) {
				$this->Session->setFlash(__('The wallet has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The wallet could not be saved. Please, try again.'));
			}
		}
		$currencies = $this->Wallet->Currency->find('list');
		$users = $this->Wallet->User->find('list');
		$this->set(compact('currencies', 'users'));
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
			if ($this->Wallet->save($this->request->data)) {
				$this->Session->setFlash(__('The wallet has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The wallet could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Wallet.' . $this->Wallet->primaryKey => $id));
			$this->request->data = $this->Wallet->find('first', $options);
		}
		$currencies = $this->Wallet->Currency->find('list');
		$users = $this->Wallet->User->find('list');
		$this->set(compact('currencies', 'users'));
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
		$list_delete = $this->deleteWallet($id);       
		if($this->deleteAllInfoOfWallet($list_delete, $id)) {
                    $this->Session->setFlash(__('The wallet has been deleted.'));
                } else {
                    $this->Session->setFlash(__('The wallet could not be deleted. Please, try again.'));
                }
		return $this->redirect(array('action' => 'index'));
	}
       
        
/**
 * deleteWallet method
 * define all transactions of categories of wallet with wallet id = $id
 * @throws NotFoundException
 * @param string $id
 * @return array
 */       
        public function deleteWallet($id) 
        {
            $list_categories = $this->Wallet->Category->find('all',array(
                    'fields' => array('Category.id'),
                    'conditions' => array('wallet_id' => $id)
                )
            );
            $list_transacton = array();
            $i=0;
            foreach ($list_categories as $category) {
                $list_transacton[$i] = array('Category_id' => $category['Category']['id'],$this->Wallet->Category->Transaction->find('all', array(
                    'fields' => array('Transaction.id'),
                    'conditions' => array('category_id' => $category['Category']['id'])
                )));
                $i++;
            }
            return $list_transacton;
        }
        
/**
 * deleteAllInfoOfWallet method
 * delete all transactions of categories of wallet with wallet id = $id
 * @throws NotFoundException
 * @param array $id
 * @return boolean
 */      
    function deleteAllInfoOfWallet($list_info, $id)
    {
        $ds = $this->Wallet->getDataSource();
        $ds->begin();
        $flag = true;
        $i = 0;
        $transation_list = 0;
        if(count($list_info) > 0) {
            foreach ($list_info as $info)
            {
                if(count($info[$transation_list])>1) {
                    $j = 0;

                    foreach ($info[$transation_list] as $transaction)
                    {
    //                    echo '<pre>';
    //                    print_r($transaction['Transaction']['id']);
    //                    echo '</pre>';
                        if($this->Wallet->Category->Transaction->delete($transaction['Transaction']['id'])) {
                            $flag = true;
                        } else {
                            $flag = false;
                        }
                        $j++;
                    }
                } else {
    //                if($this->Wallet->Category->Transaction->delete($info[$transation_list][$transation_list]['Transaction']['id'])) {
    //                    $flag = true;
    //                } else {
    //                    $flag = false;
    //                }
                    if(count($info[$transation_list]) > 0 ){
                    if($this->Wallet->Category->Transaction->delete($info[$transation_list][$transation_list]['Transaction']['id'])) {
                        $flag = true;
                    } else {
                        $flag = false;
                    }
    //                    echo $info[$transation_list][$transation_list]['Transaction']['id'];
                    }
                }
    //            echo '<pre>';
    //            print_r($info['Category_id']);
    //            echo '</pre>';
                if($this->Wallet->Category->delete($info['Category_id'])) {
                        $flag = true;
                    } else {
                        $flag = false;
                    }
                    $i++;

            }
        }
        if($this->Wallet->delete($id)) {
            $flag = true;
        } else {
            $flag = false;
        }
        echo '<pre>'; 
        print_r($list_info);
        echo '<pre>';
        if($flag) {
            $ds->commit ();
            return true;
        } else {
            $ds->rollback ();
             return false;
        }
    }
}
