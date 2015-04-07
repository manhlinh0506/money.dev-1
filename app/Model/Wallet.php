<?php
App::uses('AppModel', 'Model');
/**
 * Wallet Model
 *
 * @property Currency $Currency
 * @property User $User
 * @property Category $Category
 * @property Report $Report
 */
class Wallet extends AppModel {
    public $name = 'Wallet';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
			),
                        'length' => array(
                                'rule' => array('maxLength', 30),
                                'message' => 'Wallet name must be no larger than 30 characters long.'
                    ),
		),
		'balance' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Currency' => array(
			'className' => 'Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'wallet_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Report' => array(
			'className' => 'Report',
			'foreignKey' => 'wallet_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

   /**
     * deleteWallet method
     * define all transactions of categories of wallet with wallet id = $id
     * @throws NotFoundException
     * @param string $id
     * @return array
     */
    public function deleteWallet($id) {
        $list_categories = $this->Category->find('all', array(
            'fields' => array('Category.id'),
            'conditions' => array('wallet_id' => $id)
                )
        );
        $list_transacton = array();
        $i = 0;
        foreach ($list_categories as $category) {
            $list_transacton[$i] = array('Category_id' => $category['Category']['id'], $this->Category->Transaction->find('all', array(
                    'fields' => array('Transaction.id'),
                    'conditions' => array('category_id' => $category['Category']['id'])
            )));
            $i++;
        }
        return $list_transacton;
    }
    
    /**
     * deleteWallet method
     * define all transactions of categories of wallet with wallet id = $id
     * @throws NotFoundException
     * @param string $id
     * @return array
     */
    function deleteAllInfoOfWallet($list_info, $id) {
        $ds = $this->getDataSource();
        $ds->begin();
        $flag_transaction = true;
        $flag_category = true;
        $flag_wallet = true;
        $i = 0;
        $transation_list = 0;
        if (count($list_info) > 0) {
            foreach ($list_info as $info) {
                if (count($info[$transation_list]) > 1) {
                    foreach ($info[$transation_list] as $transaction) {
                        //                    echo '<pre>';
                        //                    print_r($transaction['Transaction']['id']);
                        //                    echo '</pre>';
                        if ($this->Category->Transaction->delete($transaction['Transaction']['id'])) {
                            $flag_transaction = true;
                        } else {
                            $flag_transaction = false;
                            break;
                        }
                    }
                } else {
                    //                if($this->Wallet->Category->Transaction->delete($info[$transation_list][$transation_list]['Transaction']['id'])) {
                    //                    $flag = true;
                    //                } else {
                    //                    $flag = false;
                    //                }
                    if (count($info[$transation_list]) > 0) {
                        if ($this->Category->Transaction->delete($info[$transation_list][$transation_list]['Transaction']['id'])) {
                            $flag_transaction = true;
                        } else {
                            $flag_transaction = false;
                            break;
                        }
                        //                    echo $info[$transation_list][$transation_list]['Transaction']['id'];
                    }
                }
                //            echo '<pre>';
                //            print_r($info['Category_id']);
                //            echo '</pre>';
                if ($this->Category->delete($info['Category_id'])) {
                    $flag_category = true;
                } else {
                    $flag_category = false;
                    break;
                }
                $i++;
                if ($flag_transaction == false || $flag_category == false) {
                    break;
                }
            }
        }
        if ($this->delete($id)) {
            $flag_wallet = true;
        } else {
            $flag_wallet = false;
        }
//        echo '<pre>'; 
//        print_r($list_info);
//        echo '<pre>';
        if ($flag_transaction && $flag_category && $flag_wallet) {
            $ds->commit();
            return true;
        } else {
            $ds->rollback();
            return false;
        }
    }
    
   /**
     * getWallet method
     * get wallets of user
     * @throws NotFoundException
     * @param  $id
     * @return array
     */
    public function getWallet($id) {
        return $this->find('all', array('conditions' => array('Wallet.user_id'=>$id)));
    }
}
