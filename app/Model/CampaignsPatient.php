<?php
App::uses('AppModel', 'Model');
/**
 * CampaignsPatient Model
 *
 * @property Campaign $Campaign
 * @property Patient $Patient
 */
class CampaignsPatient extends AppModel {

	public $validationDomain = 'CampaignsPatient';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'required' => true,
				'last' => true, // Stop validation after this rule
				'on' => 'update', // Limit validation to 'create' or 'update' operations
			),
		),
		'campaign_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Select a specific Campaign.',
				'required' => true,
				'last' => true
			),
		),
		'patient_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Select a patient to add in Campaign.',
				'required' => true,
				'last' => true
			),
		),
		'status' => array(
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Campaign' => array(
			'className' => 'Campaign',
			'foreignKey' => 'campaign_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Patient' => array(
			'className' => 'Patient',
			'foreignKey' => 'patient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
