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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

        
/**
 * beforeSace function
 * return true
 * @var array
 */        
        public function beforeSave($options = array()) 
        {
            if (isset($this->data[$this->alias]['password'])) {
                    $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password']);
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


}
?>