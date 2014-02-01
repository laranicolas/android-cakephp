<?php
App::uses('AppController', 'Controller');
/**
 * Short Messages Controller
 *
 * @property Patient $Patient
 */
class SmsController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Sm->id = $id;
		if (!$this->Sm->exists()) {
			throw new NotFoundException(__d('Sm', 'Invalid sms'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Sm->delete()) {
			$this->Session->setFlash(__d('Sm', 'Sms deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__d('Sm', 'Sms was not deleted'));
	}
}