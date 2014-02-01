<?php
App::uses('AppModel', 'Model');
/**
 * Patient Model
 *
 * @property n $n
 */
class Patient extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $validationDomain = 'Patient';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'allowEmpty' => false,
				'last' => true, // Stop validation after this rule
				'on' => 'update', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'Only alphanumeric type for name.',
				'allowEmpty' => false,
				'required' => true,
			)
		),
		'surname' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'Only alphanumeric type for surname.',
				'allowEmpty' => true,
				'required' => false,
			)
		),
		'code' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Only support numbers for the area code of patient.',
				'allowEmpty' => false,
				'required' => true
			),
			'notZero' => array(
				'rule' => array('custom','/[^0]+/m'),
				'message' => 'Introduce a valid number.',
				'last' => true
			),
			'phone' => array(
				'rule' => array('custom', '/^[0-9]{3,4}$/'),
				'message' => 'Please supply three or four numbers for area code.',
			)
		),
		'cellular' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Only support numbers for cellular number of patient.',
				'allowEmpty' => false,
				'required' => true
			),
			'notZero' => array(
				'rule' => array('custom','/[^0]+/m'),
				'message' => 'Introduce a valid number.',
				'last' => true
			),
			'phone' => array(
				//'rule' => array('custom', '/^[0-9]{7}$/'),
				'rule' => array('custom', '/^[0-9]{6,7}$/'),
				'message' => 'Please supply six or seven numbers for cellular.',
			)
		),
		'hour' => array(
			'time' => array(
				'rule' => array('time'),
				'message' => 'Insert valid hour format to send SMS.',
				'allowEmpty' => false,
				'required' => true,
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CampaignsPatient' => array(
			'className' => 'CampaignsPatient',
			'foreignKey' => 'patient_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Sm' => array(
			'className' => 'Sm',
			'foreignKey' => 'patient_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function beforeSave($options = array()) {
		if (!empty($this->data['Patient']['hour'])) {
			$this->data['Patient']['hour'] .= ':00';
		}
		return true;
	}
}
