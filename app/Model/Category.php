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

    //id of earn
    const EARN = 2;
    //id of spent
    const SPENT = 1;
    //value of default special
    const SPECIAL_NULL = null;
    // id of loan
    const SPECIAL_LOAN = 1;
    // id of borrowing
    const SPECIAL_BORROWING = 2;
    //default
    const DELETE_FLAG = 1;

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
            )
        ),
        'delete_flag' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'wallet_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'typename_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
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
        if (count($list_transaction) > 0) {
            try {
                foreach ($list_transaction as $transaction) {
                    $this->Transaction->delete($transaction['Transaction']['id']);
                }
            } catch (Exception $deleteTransaction) {
                $ds->rollback();
                return false;
            }
        }
        try {
            $this->delete($id);
            $ds->commit();
            return true;
        } catch (Exception $deleteCategory) {
            $ds->rollback();
            return false;
        }
    }

    /**
     * addDefaultCategory method
     * add 4 default categories
     * @throws NotFoundException
     * @param array $id
     * @return boolean
     */
    public function addDefaultCategory($id) {
        $this->create();
        $cate_1 = array(
            'name' => 'Other Spent',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
            'delete_flag' => self::DELETE_FLAG,
            'wallet_id' => $id,
            'typename_id' => self::SPENT,
            'special_id' => self::SPECIAL_NULL,
        );
        $this->save($cate_1);
        $this->create();
        $cate_2 = array(
            'name' => 'Other Earned',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
            'delete_flag' => self::DELETE_FLAG,
            'wallet_id' => $id,
            'typename_id' => self::EARN,
            'special_id' => self::SPECIAL_NULL,
        );
        $this->save($cate_2);
        $this->create();
        $cate_3 = array(
            'name' => 'Loan Spent',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
            'delete_flag' => self::DELETE_FLAG,
            'wallet_id' => $id,
            'typename_id' => self::SPENT,
            'special_id' => self::SPECIAL_LOAN,
        );
        $this->save($cate_3);
        $this->create();
        $cate_4 = array(
            'name' => 'Debt Earned',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
            'delete_flag' => self::DELETE_FLAG,
            'wallet_id' => $id,
            'typename_id' => self::EARN,
            'special_id' => self::SPECIAL_BORROWING,
        );
        $this->save($cate_4);
    }

    /**
     * getSpecial method
     * get special type
     * @throws NotFoundException
     * @param array $id
     * @return data
     */
    function getSpecial($id) {
        $data = $this->Special->find('first', array('conditions' => array('id' => $id)));
        return $data;
    }

    /**
     * getDeleteFlag method
     * define default category or not
     * @throws NotFoundException
     * @param array $id
     * @return delete_flag
     */
    function getDeleteFlag($id) {
        $data = $this->find('first', array('fields' => 'delete_flag', 'conditions' => array('Category.id' => $id)));
        return $data['Category']['delete_flag'];
    }

}
