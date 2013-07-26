<?php
App::uses('CakeLogInterface', 'Log');
/**
 * AppShell file
 *
 * Use models from web app to find data and construct the messages, then implement SMS task to send it.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @author 		  Lara Nicolás
 */

class SmsShell extends AppShell {
	public $uses = array('Campaign');

	public function main() {
		$ClientSoap = $this->Tasks->load('ClientSoap');
		
		if (!$data = $this->__getData()) {
			CakeLog::write('activity', 'Ningún mensaje fue enviado durante este lapso de tiempo.');
			return;
		}

		if ($ClientSoap->sendMessage($data)) {
			CakeLog::write('activity', 'Se enviaron mensajes durante este lapso de tiempo.');
			return;
		}
		return;
	}

/**
* Return array campaigns with there patients and posts allowed to specific date.
* If not exists Post or CampaignsPatient return false.
* 
* @return mixed 
*
*/
	private function __getData() {
		$dateTime = $this->__getDateTime();

		$this->Campaign->Behaviors->load('Containable');
		$data = $this->Campaign->find('all', array(
			'fields' => array('name', 'signature'),
			'conditions' => array(
				'Campaign.status' => true,
				'Campaign.end_date >=' => $dateTime['today']
			),
			'contain' => array(
				'Post' => array(
					'fields' => array('text'),
					'conditions' => array('Post.start_date' => $dateTime['today']),
					'limit' => 1
				),
				'CampaignsPatient' => array(
					'fields' => array('id'),
					'conditions' => array('CampaignsPatient.status' => true),
					'Patient' => array(
						//'fields' => array('code', 'cellular'),
						'conditions' => array('Patient.hour' => $dateTime['hour']) 
					)
				)
			)
		));

		if (!empty($data)) {
			foreach ($data as $k => $v) {
				// If is empty Post or CampaignsPatient it means we cant send a message, so unset all campaign.
				if (empty($v['Post']) || empty($v['CampaignsPatient'])) {
					unset($data[$k]);
					continue;
				}

				// If are empty Patient from CampaignsPatient, then remove unsetting all campaign.
				foreach ($v['CampaignsPatient'] as $key => $value) {
					if (empty($value['Patient'])) {
						unset($data[$k]['CampaignsPatient'][$key]);
						continue;
					}
				}

				if (empty($data[$k]['CampaignsPatient'])) {
					unset($data[$k]);
					continue;
				}
			}
		}

		if (!empty($data)) {
			return $data;
		}
		return false;
	}

/**
* Calculate current date and hour time.
*
* @return array
**/
	private function __getDateTime() {
		$dateTime = array(
			'today' => date("Y-m-d"),
			'hour' => date("H:00:00", strtotime('now'))
		);

		return $dateTime;
	}
}