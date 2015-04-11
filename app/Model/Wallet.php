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
     * getWallet method
     * get wallets of user
     * @throws NotFoundException
     * @param  $id
     * @return array
     */
    public function getWallet($id) {
        return $this->find('all', array('conditions' => array('Wallet.user_id' => $id)));
    }

    /**
     * getAllWallet method
     * get all wallet ids of user
     */
    public function getAllWallet($id) {
        $ids = $this->query('select current_wallet from users where id =' . $id);
        return $ids;
    }

    /**
     * changeCurrent method
     * change current wallet of user
     */
    public function changeCurrent($wallet_id, $user_id) {
        if ($changeWallet = $this->User->updateAll(
                array('User.current_wallet' => $wallet_id), array('User.id' => $user_id)
                )) {
            return true;
        } else {
            return false;
        }
    }

}
