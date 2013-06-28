<?php
App::uses('CampaignsPatient', 'Model');

/**
 * CampaignsPatient Test Case
 *
 */
class CampaignsPatientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.campaigns_patient',
		'app.campaign',
		'app.patient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CampaignsPatient = ClassRegistry::init('CampaignsPatient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CampaignsPatient);

		parent::tearDown();
	}

}
