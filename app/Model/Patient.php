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
	public $virtualFields = array(
		'code' => 'SUBSTRING(Patient.cellular, 1, 4)'
	);

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
				'allowEmpty' => false,
				'required' => true,
			)
		),
		'code' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Only support numbers for the area code of patient.',
				'allowEmpty' => false,
			),
			'notZero' => array(
				'rule' => array('custom','/[^0]+/m'),
				'message' => 'Introduce a valid number.',
				'last' => true
			),
			'phone' => array(
				'rule' => array('custom', '/^[0-9]{4}$/'),
				'message' => 'Please supply four numbers for area code.',
			)
		),
		'cellular' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Only support numbers for the area code of patient.',
				'allowEmpty' => false,
			),
			'notZero' => array(
				'rule' => array('custom','/[^0]+/m'),
				'message' => 'Introduce a valid number.',
				'last' => true
			),
			'phone' => array(
				'rule' => array('custom', '/^[0-9]{7}$/'),
				'message' => 'Please supply nine numbers for area code.',
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
		)
	);

	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
			if (isset($val['Patient']['cellular'])) {
				$results[$key]['Patient']['cellular'] = substr($results[$key]['Patient']['cellular'], 4);
			}
		}
		return $results;
	}

	public function beforeSave() {
		if (
			!empty($this->data['Patient']['cellular'])
			&& !empty($this->data['Patient']['code'])
			&& !empty($this->data['Patient']['hour'])
		) {
			$this->data['Patient']['hour'] .= ':00';
			$this->data['Patient']['cellular'] = $this->data['Patient']['code'] . $this->data['Patient']['cellular'];
			unset($this->data['Patient']['code']);
		}
		return true;
	}
}
