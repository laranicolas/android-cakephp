<?php
App::uses('Campaign', 'Model');

/**
 * Campaign Test Case
 *
 */
class CampaignTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.campaign',
		'app.post',
		'app.patient',
		'app.campaigns_patient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Campaign = ClassRegistry::init('Campaign');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Campaign);

		parent::tearDown();
	}

}
