<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property Post $Campaign
 */
class Post extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'text';
	public $validationDomain = 'Post';

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
				'message' => 'Select a campaign.',
				'required' => true,
				'allowEmpty' => false,
				'on' => 'create',
			),
		),
		'text' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Write a message.',
				'allowEmpty' => false,
				'required' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'Message must be no larger than 160 characters long.'
			)
		),
		'start_date' => array(
			'date' => array(
				'rule' => array('date', 'dmy'),
				'message' => 'Add a valid date dd/mm/yyyy.',
				'allowEmpty' => false,
				'required' => true
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
		)
	);

	public function afterFind($results, $primary = false) {
		foreach ($results as $k => $v) {
			if (isset($v['Post']['start_date'])) {
				$results[$k]['Post']['start_date'] = $this->__dateFormatAfterFind($v['Post']['start_date']);
			}
		}
		return $results;
	}

	public function beforeSave($options = array()) {
		if (!empty($this->data['Post']['start_date'])) {
			$this->data['Post']['start_date'] = $this->__dateFormatBeforeSave($this->data['Post']['start_date']);
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
