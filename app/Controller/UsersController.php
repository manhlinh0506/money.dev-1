<?php
App::uses ( 'AppController', 'Controller' );
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {
	
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array (
			'Paginator',
	);
	
	public $_sessionUsername = '';
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->User->recursive = 0;
		$this->set ( 'users', $this->Paginator->paginate () );
	}
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->Auth->allow ( 'add' );
	}
	function logout() {
		$this->redirect ( $this->Auth->logout () );
	}
	public function login() {
		// validation for username and password
		// $validate = array(
		// 'username' => array (
		// 'rule1' => array (
		// 'rule' => 'notEmpty',
		// 'message'=>'Email can not empty'
		// ),
		// 'rule2' => array (
		// 'rule' => 'email',
		// 'message' => 'Email is not true'
		// )
		// ),
		// 'password' => array (
		// 'notEmpty' => array (
		// 'rule' => array (
		// 'notEmpty'
		// )
		// )
		// )
		// );
		// if($this->validates($this->validate)){
		$error = '';
		if ($this->request->is('post')) {
			echo $this->Auth->password($_POST['data']['User']['password']);
			if ($this->Auth->login()) {
				$this->Session->write ( $this->_sessionUsername, $username );
				$this->redirect ($this->Auth->redirect());
			} else {
				$error = 'Username or password is wrong';
				$this->Session->setFlash ( $error );
			}
		}
		// }
		$this->render ( "/users/login" );
	}
	
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function view($id = null) {
		if (! $this->User->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}
		$options = array (
				'conditions' => array (
						'User.' . $this->User->primaryKey => $id 
				) 
		);
		$this->set ( 'user', $this->User->find ( 'first', $options ) );
	}
	
	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is ( 'post' )) {
			if ($this->User->validates ()) {
				$this->User->create ();
				$random_password = $this->generateRandomString ();
				$this->sendEmail ( $_POST ['data'] ['User'] ['username'], $random_password );
				$User = array (
						'username' => $_POST ['data'] ['User'] ['username'],
						'password' =>  $this->Auth->password($random_password)
				);
				if ($this->User->save ( $User )) {
					$this->Session->setFlash ( __ ( 'The user has been saved. Password has already sent to your email.' ) );
					return $this->redirect ( array (
							'action' => 'login' 
					) );
				} else {
					$this->Session->setFlash ( __ ( 'The user could not be saved. Please, try again.' ) );
				}
			}
		}
	}
	
	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function edit($id = null) {
		if (! $this->User->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}
		if ($this->request->is ( array (
				'post',
				'put' 
		) )) {
			if ($this->User->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The user has been saved.' ) );
				return $this->redirect ( array (
						'action' => 'index' 
				) );
			} else {
				$this->Session->setFlash ( __ ( 'The user could not be saved. Please, try again.' ) );
			}
		} else {
			$options = array (
					'conditions' => array (
							'User.' . $this->User->primaryKey => $id 
					) 
			);
			$this->request->data = $this->User->find ( 'first', $options );
		}
	}
	
	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (! $this->User->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid user' ) );
		}
		$this->request->allowMethod ( 'post', 'delete' );
		if ($this->User->delete ()) {
			$this->Session->setFlash ( __ ( 'The user has been deleted.' ) );
		} else {
			$this->Session->setFlash ( __ ( 'The user could not be deleted. Please, try again.' ) );
		}
		return $this->redirect ( array (
				'action' => 'index' 
		) );
	}
	
	/**
	 * send email method
	 *
	 * @throws NotFoundException
	 * @param string $email,
	 *        	string $password
	 * @return redirect
	 */
	public function sendEmail($user_email, $password) {
		$email = new CakeEmail ( 'gmail' );
		$email->to ( $user_email );
		$email->subject ( 'Automatically generated password' );
		$email->replyTo ( 'mail.example0506@gmail.com' );
		$email->from ( 'mail.example0506@gmail.com' );
		$email->send ( 'Hi! This is your password:' . $password . '. Please change password as soon as possible' );
	}
	
	/**
	 * password generator method
	 *
	 * @throws NotFoundException
	 * @param string $length        	
	 * @return string
	 */
	function generateRandomString($length = 8) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen ( $characters );
		$randomString = '';
		for($i = 0; $i < $length; $i ++) {
			$randomString .= $characters [rand ( 0, $charactersLength - 1 )];
		}
		return $randomString;
	}
}
