<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
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
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
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

	public $components = array(
		'Acl',
		'Auth' => array(
			'authorize' => array(
				'Actions' => array('actionPath' => 'controllers')
			)
		),
		'Session'
	);
	public $helpers = array('Html', 'Form', 'Session');

	public function beforeFilter() {
		// $this->Auth->allow();	
		//Configure AuthComponent
		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action' => 'login'
		);
		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action' => 'login'
		);
		$this->Auth->loginRedirect = array(
			'controller' => 'pages',
			'action' => 'display'
		);
	}

	public function beforeRender() {
		// Auth'ed user
		if ($authUser = AuthComponent::user()) {
			$this->set('authUser', $authUser);
		}
	}

	protected function _truncate ($string, $limit, $break = " ", $pad = "…") { 
		if (strlen($string) <= $limit) 
			return $string; 
		if (($breakpoint = strpos($string, $break, $limit)) !== false ) { 
			if ($breakpoint < strlen($string) - 1) { 
				$string = substr($string, 0, $breakpoint) . $pad; 
			}
		}
		return $string; 
	}
}
