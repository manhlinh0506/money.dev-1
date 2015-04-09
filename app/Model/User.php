<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property DefaultWallet $DefaultWallet
 * @property CurrentWallet $CurrentWallet
 * @property Wallet $Wallet
 */
class User extends AppModel {

    public $name = 'User';
    

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'username' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'The email is required'
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Invalid email'
            )
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'The password is required',
            ),
        ),
        'default_wallet' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'current_wallet' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'old_password'   => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
               'message' => 'The password is required'
          )
      ),
        'new_password' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'The new password is required'
            ),
            'between' => array(
                'rule' => array('between',8,20),
                'message' => 'Your new password must be between 8 and 20 characters.'
            ),
            'type' => array(
                'rule' => array('alphaNumeric'),
                'message' => 'The password has invalid character'
            )
        ),
        'cf_password' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'The new password is required'
            ),
            'between' => array(
                'rule' => array('between',8,20),
                'message' => 'Your confirm password must be between 8 and 20 characters.'
            ),
            'type' => array(
                'rule' => array('alphaNumeric'),
                'message' => 'The password has invalid character'
            ),
            'match' => array(
                'rule' => array('compare_password'),
                'message' => 'The confirm password is not match with new password.'
            )
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * beforeSace function
     * return true
     * @var array
     */
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Wallet' => array(
            'className' => 'Wallet',
            'foreignKey' => 'user_id',
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
     * checkEmail action
     * return true
     * @var string
     */
    function checkEmail($email) {
        $exist_email = $this->find('all', array(
            'fields' => 'User.username',
            'conditions' => array('username' => $email))
        );
        if (count($exist_email) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * compare_password action
     * return true
     * 
     */
    public function compare_password() {
        return $this->data[$this->alias]['new_password'] === $this->data[$this->alias]['cf_password'];
    }
    
    
    /**
     * check_password action
     * return true
     * 
     */
    public function check_password($old_password, $username) {
        $user = $this->find('count', array(
            'conditions' => array(
                'User.username' => $username,
                'password' => AuthComponent::password($old_password) )
            )
        );
        if($user > 0) return true;
        else return false;
    }
    
    public function getUserInfo($id) {
        $userInfo =  $this->find('first', array(
            'fields' => array('default_wallet','current_wallet'),
            'conditions' => array('User.id' => $id)
            )
        );
        return $userInfo;
    }
    
    public function checkWallet($id)
    {
        $wallet = $this->Wallet->find('first', array('conditions'=>array('Wallet.user_id'=>$id)));
        return $wallet;
    }
}
?>