<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		// $this->Auth->allow('initDB');
	}

	//Used to configure the actions allowed between aros & acos.
	// public function initDB() {
	// 	$group = $this->User->Group;
		
	// 	// Allow admins to everything
	// 	$group->id = 1;
	// 	$this->Acl->allow($group, 'controllers');

	// 	// Allow moderators 
	// 	$group->id = 2;
	// 	$this->Acl->deny($group, 'controllers');
	// 	$this->Acl->allow($group, 'controllers/Pages/display');
	// 	$this->Acl->allow($group, 'controllers/Users/login');
	// 	$this->Acl->allow($group, 'controllers/Users/logout');
	// 	$this->Acl->allow($group, 'controllers/Posts');
	// 	$this->Acl->allow($group, 'controllers/Patients');
	// 	$this->Acl->allow($group, 'controllers/Campaigns');
	// 	$this->Acl->allow($group, 'controllers/CampaignsPatients');

	// 	// Allow users to only view actions
	// 	$group->id = 3;
	// 	$this->Acl->deny($group, 'controllers');
	// 	$this->Acl->allow($group, 'controllers/Pages/display');
	// 	$this->Acl->allow($group, 'controllers/Users/login');
	// 	$this->Acl->allow($group, 'controllers/Users/logout');
	// 	$this->Acl->allow($group, 'controllers/Posts/index');
	// 	$this->Acl->allow($group, 'controllers/Posts/view');
	// 	$this->Acl->allow($group, 'controllers/Patients/index');
	// 	$this->Acl->allow($group, 'controllers/Patients/view');
	// 	$this->Acl->allow($group, 'controllers/Campaigns/index');
	// 	$this->Acl->allow($group, 'controllers/Campaigns/view');
	// 	$this->Acl->allow($group, 'controllers/CampaignsPatients/index');
	// 	// We add an exit to avoid an ugly "missing views" error message
	// 	echo "all done";
	// 	exit;
	// }

/**
 * Log in a User.
 */
	public function login() {
		$this->layout = 'login';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__d('User', 'User or Password not valid.'));
				return;
			}
		}
		// if ($this->Auth->user()) {
		// 	$this->redirect($this->Auth->loginRedirect);
		// }
	}

/**
 * Log out a logged in User.
 */
	public function logout() {
		$this->Session->setFlash('Good-Bye');
		$this->redirect($this->Auth->logout());
		// if ($this->Cookie->read('Auth.User')) {
		// 	$this->Cookie->delete('Auth.User');
		// }
		// $this->redirect($this->Auth->logout());
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__d('User', 'Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__d('User', 'The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('User', 'The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__d('User', 'Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__d('User', 'The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('User', 'The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
		if (!$this->User->exists()) {
			throw new NotFoundException(__d('User', 'Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__d('User', 'User deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__d('User', 'User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
