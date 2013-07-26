<?php
App::uses('AppController', 'Controller');
/**
 * CampaignsPatients Controller
 *
 * @property CampaignsPatient $CampaignsPatient
 */
class CampaignsPatientsController extends AppController {

	public $components = array('RequestHandler');

	public $paginate = array(
		'limit' => 13,
		'order' => array(
		'CampaignsPatient.campaign_id' => 'asc'
		)
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CampaignsPatient->recursive = 0;
		$this->set('campaignsPatients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function view($id = null) {
	// 	if (!$this->CampaignsPatient->exists($id)) {
	// 		throw new NotFoundException(__('Invalid campaigns patient'));
	// 	}
	// 	$options = array('conditions' => array('CampaignsPatient.' . $this->CampaignsPatient->primaryKey => $id));
	// 	$this->set('campaignsPatient', $this->CampaignsPatient->find('first', $options));
	// }

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$formatData = $this->__formatCheckboxData($this->request->data);

			$this->CampaignsPatient->create();
			if ($this->CampaignsPatient->saveMany($formatData)) {
				$this->Session->setFlash(__d('CampaignsPatient', 'The campaigns patient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('CampaignsPatient', 'The campaigns patient could not be saved. Please, try again.'));
			}
		}
		$campaigns = $this->CampaignsPatient->Campaign->find('list');
		$this->set(compact('campaigns'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CampaignsPatient->exists($id)) {
			throw new NotFoundException(__d('CampaignsPatient', 'Invalid campaigns patient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CampaignsPatient->save($this->request->data)) {
				$this->Session->setFlash(__d('CampaignsPatient', 'The campaigns patient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('CampaignsPatient', 'The campaigns patient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CampaignsPatient.' . $this->CampaignsPatient->primaryKey => $id));
			$this->request->data = $this->CampaignsPatient->find('first', $options);
		}
		$campaigns = $this->CampaignsPatient->Campaign->find('list');
		$patients = $this->CampaignsPatient->Patient->find('list');
		$this->set(compact('campaigns', 'patients'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CampaignsPatient->id = $id;
		if (!$this->CampaignsPatient->exists()) {
			throw new NotFoundException(__d('CampaignsPatient', 'Invalid campaigns patient'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ($this->CampaignsPatient->delete()) {
			$this->Session->setFlash(__d('CampaignsPatient', 'Campaigns patient deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__d('CampaignsPatient', 'Campaigns patient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
*
* Return campaignsPatients that not include in campaign selected.
* Only use when request is Post and request is not empty.
*
* @throws NotFoundException
*
*/
	public function ajax_searchPatients() {
		if (!$this->request->is('post') || empty($this->request->data)) {
			throw new NotFoundException(__d('CampaignsPatient', 'Invalid campaigns patient'));
		}

		$campaign_id = $this->request->data['CampaignsPatient']['campaign_id'];

		$patients = $this->CampaignsPatient->find('list', array(
			'fields' => array('CampaignsPatient.patient_id'),
			'conditions' => array('CampaignsPatient.campaign_id' => $campaign_id)
			)
		);

		$conditions = 'Patient.id';
		if (!empty($patients)) {
			$conditions = array('Patient.id NOT IN (' . implode(',', $patients) . ')');
		}

		$this->paginate = array(
			'limit' => 5,
			'conditions' => $conditions
		);
		$this->set('patients', $this->paginate('Patient'));

		$this->layout = false;
		$this->render('/Elements/ajax_table');
	}

/**
* format checkbox data
*
* @throws NotFoundException
* @param array campaignPatients
* @return mixed formatCampaignPatients
*/

	private function __formatCheckboxData($campaignPatients = array()) {
		if (empty($campaignPatients)) {
			throw new NotFoundException(__d('CampaignsPatient', 'Invalid campaigns patient'));
		}
		
		if (!array_key_exists('patient_id', $campaignPatients['CampaignsPatient'])) {
			return;
		}
		$campaign_id = $campaignPatients['CampaignsPatient']['campaign_id'];
		$patients = array_values($campaignPatients['CampaignsPatient']['patient_id']);

		$formatCampaignPatients = array();
		foreach ($patients as $k => $v) {
			$formatCampaignPatients[$k]['campaign_id'] = $campaign_id;
			$formatCampaignPatients[$k]['patient_id'] = $v;
			$formatCampaignPatients[$k]['status'] = 1;
		}

		return $formatCampaignPatients;
	}

}
