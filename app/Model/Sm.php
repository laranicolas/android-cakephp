<?php
App::uses('AppModel', 'Model');
/**
 * Short Message Model
 *
 * @property n $n
 */
class Sm extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'text';
	public $validationDomain = 'Sm';

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
		'patient_id' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'Only alphanumeric type for name.',
				'allowEmpty' => false,
				'required' => true,
			)
		)
	);

}