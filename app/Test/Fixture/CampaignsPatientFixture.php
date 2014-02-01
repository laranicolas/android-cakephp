<?php
/**
 * CampaignsPatientFixture
 *
 */
class CampaignsPatientFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'campaign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'patient_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'u_campaign_patient' => array('column' => array('campaign_id', 'patient_id'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'campaign_id' => 1,
			'patient_id' => 1,
			'status' => 1
		),
	);

}
