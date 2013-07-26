<?php
App::uses('AppModel', 'Model');
/**
 * Campaign Model
 *
 * @property Post $Post
 * @property Patient $Patient
 */
class Campaign extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $validationDomain = 'Campaign';

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
		'name' => array(
			// 'alphanumeric' => array(
			// 	'rule' => array('alphanumeric'),
			// 	'message' => 'Add a valid alphanumeric name.',
			// 	'required' => true
			// ),
		),
		'start_date' => array(
			'date' => array(
				'rule' => array('date', 'dmy'),
				'message' => 'Add a valid start date dd/mm/yy.',
				'required' => true
			)
		),
		'end_date' => array(
			'date' => array(
				'rule' => array('date', 'dmy'),
				'message' => 'Add a valid end date dd/mm/yy.',
				'required' => true
			),
			'comparison' => array(
				'rule' => array('checkStartEndDate'),
				'message' => 'End date must be greater than start date.'
			)
		),
		'status' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'Add status for the campaign.',
			),
		),
		'signature' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Add signature that represents campaign.',
				'allowEmpty' => false,
				'required' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 18),
				'message' => 'Message must be no larger than 18 characters long.'
			)
		),
	);


	public function checkStartEndDate() {
		$startDate = strtotime(str_replace('/', '-', $this->data['Campaign']['start_date']));
		$endDate = strtotime(str_replace('/', '-', $this->data['Campaign']['end_date']));

		if ($startDate > $endDate) {
			return false;
		}
		return true;
	}

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'campaign_id',
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
		'CampaignsPatient' => array(
			'className' => 'CampaignsPatient',
			'foreignKey' => 'campaign_id',
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
		foreach ($results as $k => $v) {
			if (
				isset($v['Campaign']['start_date']) 
				&& isset($v['Campaign']['end_date'])
			) {
				$results[$k]['Campaign']['start_date'] = $this->__dateFormatAfterFind($v['Campaign']['start_date']);
				$results[$k]['Campaign']['end_date'] = $this->__dateFormatAfterFind($v['Campaign']['end_date']);
			}
		}
		return $results;
	}

	public function beforeSave($options = array()) {
		if (!empty($this->data['Campaign']['start_date']) && !empty($this->data['Campaign']['end_date'])) {
			$this->data['Campaign']['start_date'] = $this->__dateFormatBeforeSave($this->data['Campaign']['start_date']);
			$this->data['Campaign']['end_date'] = $this->__dateFormatBeforeSave($this->data['Campaign']['end_date']);
		}
		return true;
	}

	private function __dateFormatBeforeSave($dateString) {
		return date('Y-m-d', strtotime(str_replace('/', '-', $dateString)));
	}

	private function __dateFormatAfterFind($dateString) {
		return date('d/m/Y', strtotime($dateString));
	}
}
