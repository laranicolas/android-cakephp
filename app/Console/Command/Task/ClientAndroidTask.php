<?php
App::uses('CakeLogInterface', 'Log');
/**
 * ClientAndroidTask file
 *
 * Create a client to connect to gateway sms and send message (xml).
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @author 		  Lara Nicolás
 */

class ClientAndroidTask extends Shell {

/**
* Ip and port from sms gateway.
*/
	public $smsGateway = 'http://127.0.0.1';
/**
* Sms gateway port.
*/
	public $port = 9090;	

/**
* Password used to connect with sms gateway
*/
	private $__password = '53nd5m5';

/**
* Initiate curl client.
*/
	public function __construct() {
		$this->client = curl_init();
	}

/**
* Use Android Client to send messages.
*
* @param array $data
* @return boolean 
*
**/
	public function sendMessage($data) {
		$messages = $this->__prepareMessage($data);
		
		foreach ($messages as $message) {
			$url = $this->__createUrl($message);
			// Set curl options
			curl_setopt_array($this->client, array(
				CURLOPT_URL => $url,
				CURLOPT_FAILONERROR => true,
				CURLOPT_PORT => $this->port,
				CURLOPT_HTTPHEADER => array('Content-Type:text/html; charset=utf-8')
			));
			
			if (!curl_exec($this->client)) {
				CakeLog::write('ClientAndroid', 'Error durante el envío: ' . curl_error($this->client) . ' Code: ' . curl_errno($this->client));
				return false;
			}

			CakeLog::write('patients', 'phone sent to: ' . $message['phone']);
			curl_close($this->client);
		}
		return true;
	}

/**
* Prepare message to send it.
*
* @param array $data
* @return array $message
*
**/
	private function __prepareMessage($data) {
		$countPatients = 0;
		foreach ($data as $k => $v) {
			$post = Set::extract('Post.{n}', $v);
			$patients = Set::extract('CampaignsPatient.{n}.Patient', $v);

			foreach ($patients as $patient => $attribute) {
				$message[$countPatients] = array(
					'text' => rawurlencode($this->__convertToAscii($post[0]['text']) . "\n" . $this->__convertToAscii($v['Campaign']['signature'])),
					'phone' => $attribute['code'] . $attribute['cellular'],
					'password' => $this->__password
				);
				$countPatients += 1;
			}
		}

		return $message;
	}

/**
* Remove all characters not available in sms message (only ASCII encode).
*
* @param string $string
* @return string $string
*
**/
	private function __convertToAscii($string) {
		return iconv(mb_detect_encoding($string), "ASCII//TRANSLIT", $string);
	}

/**
* Create url GET.
*
* @param array $parameters
* @return string $url
*
**/
	private function __createUrl($parameters) {
		$queryString = '';
		foreach ($parameters as $k => $v) {
			$queryString .= $k . '=' . $v . '&';
		}
		$queryString = rtrim($queryString, '&');

		return $url = $this->smsGateway . '/sendsms?' . $queryString;
	}
}