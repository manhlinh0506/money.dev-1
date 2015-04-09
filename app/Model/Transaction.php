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
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'length' => array(
                'rule' => array('maxLength', 30),
                'message' => 'Wallet name must be no larger than 30 characters long.'
            )
        ),
        'category_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
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
        'parent_transaction' => array(
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
     *
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
     *
     * @var $id
     */
    public function getLoan($id)
    {
        $loan_details = $this->query('select * from users,wallets,categories,transactions '
                . 'where users.id = ' . $id . ' and users.id = wallets.user_id and '
                . 'wallets.id = categories.wallet_id and categories.id = transactions.category_id '
                . 'and categories.special_id = ' . self::LOAN.' and transactions.parent_transaction is null');
        return $loan_details;
    }

    /**
     * getBorrowing function
     *
     * @var $id
     */
    public function getBorrowing($id)
    {
        $borrowing_details = $this->query('select * from users,wallets,categories,transactions '
                . 'where users.id = ' . $id . ' and users.id = wallets.user_id and '
                . 'wallets.id = categories.wallet_id and categories.id = transactions.category_id '
                . 'and categories.special_id = ' . self::BORROWING.' and transactions.parent_transaction is null');
        return $borrowing_details;
    }

    /**
     * getCategory function
     *
     * @var $id
     */
    public function getCategory($id)
    {
        $categories = $this->query('select categories.id, categories.name from users, wallets, categories where users.id=' . $id . ''
                . ' and users.id = wallets.user_id and wallets.id = categories.wallet_id');
        $arr = array();
        for ($i = 0; $i < count($categories); $i++) {
            $arr[$categories[$i]['categories']['id']] = $categories[$i]['categories']['name'];
        }
        return $arr;
    }

    public function getFirstCategory($user_id, $category_id)
    {
        $special_type = $this->query('select special_id from categories where categories.id=' . $category_id);
        $special_id = $special_type[0]['categories']['special_id'];
        $data = $this->query('select * from users,wallets,categories,transactions '
                . 'where users.id = ' . $user_id . ' and users.id = wallets.user_id and '
                . 'wallets.id = categories.wallet_id and categories.id = transactions.category_id '
                . 'and categories.special_id = ' . $special_id.' and transactions.parent_transaction is null');
        return $data;
    }
    
    public function checkSpecial($id)
    {
        $data = $this->query('select special_id from categories where categories.id ='.$id);
        return $data[0]['categories']['special_id'];
    }
    
    public function getChild_transaction($id)
    {
        $list_child = $this->find('list', array('conditions'=>array('parent_transaction'=>$id)));
        return $list_child;
    }
}
