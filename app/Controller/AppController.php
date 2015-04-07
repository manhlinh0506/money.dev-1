<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $helpers = array('Html','Form');
    public $components = array('DebugKit.Toolbar', 'Session', 'Auth' => array(
            'loginRedirect' => array('controller' => 'wallets', 'action' => 'add'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login')
        ) , 'Email');
    
    public function beforeFilter()
    {
        Configure::write('Config.language', $this->Session->read('Config.language'));
        $this->set('logged_in', $this->_isLogin());
        $this->set('users_userid', $this->_usersUserID());
        $this->set('users_username', $this->_usersUsername());
        $this->Session->write('Current_Wallet', $this->_usersCurrentWallet());
    }
    
/*
 * check login
 */    
    function _isLogin(){
    $login = false;
    if($this->Auth->user()){
        $login = true;
    }
    return $login;
  }
  
   /**
   * check userID
   */ 
  function _usersUserID(){
    $users_userid = null;
    if($this->Auth->user())
        $users_userid = $this->Auth->user("id");
    return $users_userid;
  }
  
  /**
   * check username
   */ 
  function _usersUsername(){
    $users_username = null;
    if($this->Auth->user())
        $users_username = $this->Auth->user("username");
    return $users_username;
  }
  
  /**
   * check current_wallet
   */ 
  function _usersCurrentWallet(){
    $users_currentWallet = null;
    if($this->Auth->user())
        $users_currentWallet = $this->Auth->user("current_wallet");
    return $users_currentWallet;
  }
}
