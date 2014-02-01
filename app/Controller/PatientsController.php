<?php
App::uses('AppController', 'Controller');
/**
 * Patients Controller
 *
 * @property Patient $Patient
 */
class PatientsController extends AppController {

	public $helpers = array('Time');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('addResponse');
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Patient->recursive = 0;
		$this->set('patients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Patient->exists($id)) {
			throw new NotFoundException(__d('Patient', 'Invalid patient'));
		}

		$this->Patient->Behaviors->load('Containable');
		$options = array(
			'conditions' => array('Patient.' . $this->Patient->primaryKey => $id),
			'contain' => array(
				'CampaignsPatient' => array('Campaign'),
				'Sm'
			)
		);
		$this->set('patient', $this->Patient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Patient->create();
			if ($this->Patient->save($this->request->data)) {
				$this->Session->setFlash(__d('Patient', 'The patient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('Patient', 'The patient could not be saved. Please, try again.'));
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
		if (!$this->Patient->exists($id)) {
			throw new NotFoundException(__d('Patient', 'Invalid patient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Patient->save($this->request->data)) {
				$this->Session->setFlash(__d('Patient', 'The patient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('Patient', 'The patient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Patient.' . $this->Patient->primaryKey => $id));
			$this->request->data = $this->Patient->find('first', $options);
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
		$this->Patient->id = $id;
		if (!$this->Patient->exists()) {
			throw new NotFoundException(__d('Patient', 'Invalid patient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Patient->delete()) {
			$this->Session->setFlash(__d('Patient', 'Patient deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__d('Patient', 'Patient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * Patients respond to app with sms from them cellulars.
 * This method authenticate with patient and save information.
 *
 * @throws NotFoundException InternalErrorException
 * @return void
 */
	public function addResponse() {
		if (
			!$this->request->is('get') ||
			!isset($_SERVER['HTTP_PHONE']) || empty($this->request->query['text'])
		) {
			throw new InternalErrorException();
		}

		$smsPhone = ltrim($_SERVER['HTTP_PHONE'], '+549');
		$smsText = $this->request->query['text'];
		$this->log($smsPhone . $smsText);
		if ($id = $this->__verifyPhone($smsPhone)) {

			$this->Patient->id = $id;
			if (!$this->Patient->exists()) {
				throw new NotFoundException(__d('Patient', 'Invalid patient'));
			}

			$data['Sm'] = array(
				'patient_id' => $id,
				'text' => $smsText
			);
			$this->log($data);
			if ($this->Patient->Sm->save($data)) {
				return;
			}
		}

		$this->log('Error incoming sms');
	}

/**
 * Find if exist the sms phone came via http and return id from patient.
 * In another case return false.
 *
 * @param int $smsPhone
 * @return mixed boolean | int
 */
	private function __verifyPhone($smsPhone) {

		$phones = hash::combine(
			$this->Patient->find('all', array('fields' => array('code', 'cellular'))),
			'{n}.Patient.id',
			array('%s%s', '{n}.Patient.code', '{n}.Patient.cellular')
		);
		foreach ($phones as $id => $phone) {
			if ($phone === $smsPhone) {
				return $id;
			}
		}
		return false;
	}
}
