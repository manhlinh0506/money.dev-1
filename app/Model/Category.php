<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Wallet $Wallet
 * @property Typename $Typename
 * @property Special $Special
 * @property Transaction $Transaction
 */
class Category extends AppModel {
    public $name = 'Category';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'delete_flag' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'wallet_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'typename_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'special_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Wallet' => array(
			'className' => 'Wallet',
			'foreignKey' => 'wallet_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Typename' => array(
			'className' => 'Typename',
			'foreignKey' => 'typename_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Special' => array(
			'className' => 'Special',
			'foreignKey' => 'special_id',
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
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'category_id',
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
     * define all transactions of category with category id = $id
     * @throws NotFoundException
     * @param string $id
     * @return array
     */
    public function getTransaction($id) {
        $list_transaction = $this->Transaction->find('all', array(
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
        $ds = $this->getDataSource();
        $ds->begin();
        $flag_transaction = true;
        $flag_category = true;
        if (count($list_transaction) > 0) {
            foreach ($list_transaction as $transaction) {
                if ($this->Transaction->delete($transaction['Transaction']['id'])) {
                    $flag_transaction = true;
                } else {
                    $flag_transaction = false;
                    break;
                }
            }
        }
        if ($this->delete($id)) {
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
