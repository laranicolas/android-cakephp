<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Group $Group
 */
class User extends AppModel {

	public $name = 'User';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'allowEmpty' => false,
				'required' => 'update',
				'last' => true, // Stop validation after this rule
				'on' => 'update', // Limit validation to 'create' or 'update' operations
			),
		),
		'username' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				// 'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	// public $actsAs = array('Acl' => array('type' => 'requester'));

	public function beforeSave($options = array()) {
		$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		return true;
	}

/**
 * This is used by the AclBehavior to determine parent->child relationships.
 *
 * @return null or parent Model reference.
 * @TODO Used when Users becames Cpanel users exclusively, because we don't want Users to update Aros tables whenever they are upated.
 * Later, attach the Acl behavior in ARO mode:
 *   array('Acl' => array('type' => 'requester'));
 */
	// public function parentNode() {
	// 	if (!$this->id && empty($this->data)) {
	// 		return null;
	// 	}
	// 	if (isset($this->data['User']['group_id'])) {
	// 		$groupId = $this->data['User']['group_id'];
	// 	} else {
	// 		$groupId = $this->field('group_id');
	// 	}
	// 	if (!$groupId) {
	// 		return null;
	// 	} else {
	// 		return array('Group' => array('id' => $groupId));
	// 	}
	// }

/**
 * Skip checking User Aros, but check Group Aros.
 *
 * Note: See Controller::isAuthorized().
 *
 * @param array $user
 * @return array
 */
	public function bindNode($user) {
		return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}
}
