<?php

App::uses('AppModel', 'Model');

/**
 * Transaction Model
 *
 * @property Category $Category
 */
class Transaction extends AppModel {

    public $name = 'Transaction';

    // id of loan
    const LOAN = 1;
    // id of borrowing
    const BORROWING = 2;

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
        'transaction_value' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            ),
            'numeric' => array(
                'rule' => array('numeric')
            )
        ),
        'category_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'delete_flag' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'parent_transaction' => array(
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
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * getValue function
     * get information of category
     * @var $id
     */
    public function getValue($id)
    {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid id'));
        }
        $data = $this->Category->find('first', array('conditions' => array('Category.id' => $id)));
        return $data;
    }

    /**
     * getLoan function
     * get categories have loan type
     * @var $id
     */
    public function getLoan($id, $transaction_id)
    {
        $current_wallet = $this->Category->Wallet->getAllWallet($id);
        $loan_details = $this->query('select * from users,wallets,categories,transactions '
                . 'where users.id = ' . $id . ' and users.id = wallets.user_id and '
                . $current_wallet[0]['users']['current_wallet'] . ' = wallets.id and '
                . $current_wallet[0]['users']['current_wallet'] . ' = categories.wallet_id and categories.id = transactions.category_id '
                . 'and categories.special_id = ' . self::LOAN . ' and transactions.parent_transaction is null '
                . 'and transactions.id !=' . $transaction_id);
        return $loan_details;
    }

    /**
     * getBorrowing function
     * get categories have borrowing type
     * @var $id
     */
    public function getBorrowing($id, $transaction_id)
    {
        $current_wallet = $this->Category->Wallet->getAllWallet($id);
        $borrowing_details = $this->query('select * from users,wallets,categories,transactions '
                . 'where users.id = ' . $id . ' and users.id = wallets.user_id and '
                . $current_wallet[0]['users']['current_wallet'] . ' = wallets.id and '
                . $current_wallet[0]['users']['current_wallet'] . ' = categories.wallet_id and categories.id = transactions.category_id '
                . 'and categories.special_id = ' . self::BORROWING . ' and transactions.parent_transaction is null'
                . ' and transactions.id != ' . $transaction_id);
        return $borrowing_details;
    }

    /**
     * getCategory function
     * get all categories of current wallet
     * @var $id
     */
    public function getCategory($id)
    {
        $current_wallet = $this->Category->Wallet->getAllWallet($id);
        if($current_wallet[0]['users']['current_wallet'] == null) {
            return null;
        }
        $categories = $this->query('select categories.id, categories.name from users, wallets, categories where users.id=' . $id . ''
                . ' and users.id = wallets.user_id and wallets.id = ' . $current_wallet[0]['users']['current_wallet'] . ' and wallets.id = categories.wallet_id');
        $arr = array();
        for ($i = 0; $i < count($categories); $i++) {
            $arr[$categories[$i]['categories']['id']] = $categories[$i]['categories']['name'];
        }
        return $arr;
    }

    /**
     * getFirstCategory function
     * get all transaction of first categories when display at add category page
     * @var $user_id, $category_id
     */
    public function getFirstCategory($user_id, $category_id)
    {
        $current_wallet = $this->Category->Wallet->getAllWallet($user_id);
        $special_type = $this->query('select special_id from categories where categories.id=' . $category_id);
        $special_id = $special_type[0]['categories']['special_id'];
        $data = array();
        if ($special_id != null && $special_id != '') {
            $data = $this->query('select * from users,wallets,categories,transactions '
                    . 'where users.id = ' . $user_id . ' and users.id = wallets.user_id and '
                    . ' wallets.id = ' . $current_wallet[0]['users']['current_wallet'] . ' and wallets.id = categories.wallet_id and categories.id = transactions.category_id '
                    . 'and categories.special_id = ' . $special_id . ' and transactions.parent_transaction is null');
        }
        return $data;
    }

    /**
     * checkSpecial function
     * check special type
     * @var $id
     */
    public function checkSpecial($id)
    {
        $data = $this->query('select special_id from categories where categories.id =' . $id);
        return $data[0]['categories']['special_id'];
    }

    /**
     * getChild_transaction function
     * get child transactions if exist
     * @var $id
     */
    public function getChild_transaction($id)
    {
        $list_child = $this->find('list', array('conditions' => array('parent_transaction' => $id)));
        return $list_child;
    }

    /**
     * getFirstCategoryToEdit function
     * get first category to display in edit transaction form
     * @var $user_id, $category_id, $transaction_id
     */
    public function getFirstCategoryToEdit($user_id, $category_id, $transaction_id)
    {
        $current_wallet = $this->Category->Wallet->getAllWallet($user_id);
        $special_type = $this->query('select special_id from categories where categories.id=' . $category_id);
        $special_id = $special_type[0]['categories']['special_id'];
        $data = array();
        if ($special_id != null && $special_id != '') {
            $data = $this->query('select * from users,wallets,categories,transactions '
                    . 'where users.id = ' . $user_id . ' and users.id = wallets.user_id and '
                    . ' wallets.id = ' . $current_wallet[0]['users']['current_wallet'] . ' and wallets.id = categories.wallet_id and categories.id = transactions.category_id '
                    . 'and categories.special_id = ' . $special_id . ' and transactions.parent_transaction is null and transactions.id != ' . $transaction_id);
        }
        return $data;
    }

    /**
     * getLoanAdd function
     * get categories have loan type to edit transaction
     * @var $id
     */
    public function getLoanAdd($id)
    {
        $current_wallet = $this->Category->Wallet->getAllWallet($id);
        $loan_details = $this->query('select * from users,wallets,categories,transactions '
                . 'where users.id = ' . $id . ' and users.id = wallets.user_id and '
                . $current_wallet[0]['users']['current_wallet'] . ' = wallets.id and '
                . $current_wallet[0]['users']['current_wallet'] . ' = categories.wallet_id and categories.id = transactions.category_id '
                . 'and categories.special_id = ' . self::LOAN . ' and transactions.parent_transaction is null');
        return $loan_details;
    }

    /**
     * getBorrowingAdd function
     * get categories have borrowing type to edit transaction
     * @var $id
     */
    public function getBorrowingAdd($id)
    {
        $current_wallet = $this->Category->Wallet->getAllWallet($id);
        $borrowing_details = $this->query('select * from users,wallets,categories,transactions '
                . 'where users.id = ' . $id . ' and users.id = wallets.user_id and '
                . $current_wallet[0]['users']['current_wallet'] . ' = wallets.id and '
                . $current_wallet[0]['users']['current_wallet'] . ' = categories.wallet_id and categories.id = transactions.category_id '
                . 'and categories.special_id = ' . self::BORROWING . ' and transactions.parent_transaction is null');
        return $borrowing_details;
    }

    public function searchByDate($datetime, $id)
    {
        $current_wallet = $this->Category->Wallet->getAllWallet($id);
        $data = $this->query("select transactions.id, transactions.name, transactions.transaction_value, "
                . "transactions.created, transactions.modified, categories.name, transactions.date_of_execution,"
                . "transactions.parent_transaction from users, wallets, categories, transactions where "
                . "users.id = ".$id." and wallets.id = ".$current_wallet[0]['users']['current_wallet'].""
                . " and wallets.user_id =".$id." and wallets.id = categories.wallet_id and "
                . "transactions.category_id = categories.id and transactions.date_of_execution = '".$datetime."'");
        return $data;
    }
}
