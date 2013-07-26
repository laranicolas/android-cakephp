<?php
App::uses('AppController', 'Controller');
/**
 * Campaigns Controller
 *
 * @property Campaign $Campaign
 */
class CampaignsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Campaign->recursive = 0;
		$this->set('campaigns', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Campaign->exists($id)) {
			throw new NotFoundException(__d('Campaign', 'Invalid campaign'));
		}

		$this->Campaign->Behaviors->load('Containable');
		$options = array(
			'conditions' => array('Campaign.' . $this->Campaign->primaryKey => $id),
			'contain' => array(
				'Post',
				'CampaignsPatient' => array('Patient')
			)
		);
		$this->set('campaign', $this->Campaign->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Campaign->create();
			if ($this->Campaign->save($this->request->data)) {
				$this->Session->setFlash(__d('Campaign', 'The campaign has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('Campaign', 'The campaign could not be saved. Please, try again.'));
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
		if (!$this->Campaign->exists($id)) {
			throw new NotFoundException(__d('Campaign', 'Invalid campaign'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Campaign->save($this->request->data)) {
				$this->Session->setFlash(__d('Campaign', 'The campaign has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('Campaign', 'The campaign could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Campaign.' . $this->Campaign->primaryKey => $id));
			$this->request->data = $this->Campaign->find('first', $options);
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
		$this->Campaign->id = $id;
		if (!$this->Campaign->exists()) {
			throw new NotFoundException(__d('Campaign', 'Invalid campaign'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Campaign->delete()) {
			$this->Session->setFlash(__d('Campaign', 'Campaign deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__d('Campaign', 'Campaign was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
