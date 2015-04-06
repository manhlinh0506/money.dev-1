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
	
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() 
        {
		$this->User->recursive = 0;
		$this->set ( 'users', $this->Paginator->paginate () );
	}
        
//	public function beforeFilter() 
//        {
//		parent::beforeFilter ();
//		$this->Auth->allow('add');        
//	}
        
        /**
	 * forgot method
	 *
	 * @return void
	 */
        function forgot()
        {
            if($this->request->is('post') && !empty($this->request->data)) {
                if($this->checkEmail(mysql_real_escape_string($_POST['username']))) {
                    $random_password = $this->generateRandomString();
                    $this->sendEmail($_POST['username'], $random_password);
                    $this->Session->setFlash('New password already sent to your email.');
                } else {
                    $this->Session->setFlash('Invalid Email');
                }
            }
        }
            
	function logout() 
        {
		$this->redirect ( $this->Auth->logout () );
	}
        
	public function login() 
        {
		$error = '';
		if ($this->request->is('post') && !empty($this->request->data)) {
                       // $username = $_POST['data']['User']['username'];
                       // $password = $_POST['data']['User']['password'];
                       // die();
			if ($this->Auth->login()) {
				//$this->Session->write ( 'Username', $username );
				$this->redirect ($this->Auth->redirect());
			} else {
				$error = 'Username or password is wrong';
				$this->Session->setFlash ( $error );
			}
		}
                $this->render('/users/login');
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
	public function add() 
        {
		if ($this->request->is ( 'post' )) {
			if ($this->User->validates ()) {
				$this->User->create ();
				$random_password = $this->generateRandomString ();
				$this->sendEmail ( mysql_real_escape_string($_POST ['data'] ['User'] ['username']), $random_password );
				$User = array (
						'username' => $_POST ['data'] ['User'] ['username'],
						'password' => $random_password
				);
				if ($this->User->save( $User )) {
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
	public function edit($id = null) 
        {
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
	public function delete($id = null) 
        {
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
	function generateRandomString($length = 8) 
        {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen ( $characters );
		$randomString = '';
		for($i = 0; $i < $length; $i ++) {
			$randomString .= $characters [rand ( 0, $charactersLength - 1 )];
		}
		return $randomString;
	}
        
        
        /**
 * checkLogin action
 * return true
 * @var array
 */        
        function checkLogin($username, $password)
        {
            $user = $this->User->find('all', array(
                                            'fields' => array('User.username'),
                                            'conditions' => array(
                                            'User.username' => mysql_real_escape_string($username),
                                            'User.password' => Security::hash(mysql_real_escape_string($password))
                        )
                    )
                );
            if(count($user)>0) {
                return true;
            }
            else return false;
        }
        
        function checkEmail($email) {
            $exist_email = $this->User->find('all',array(
                'fields' => 'User.username',
                'conditions' => array('username' => $email))
            );
            if(count($exist_email) > 0) {
                return true;
            } else {
                return false;
            }
        }
}
