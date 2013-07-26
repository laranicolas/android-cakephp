<?php
App::uses('CakeLogInterface', 'Log');
/**
 * ClientSoapTask file
 *
 * Create a client to connect to SOAP server and send message (xml).
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @author 		  Lara Nicolás
 */

class ClientSoapTask extends Shell {
	
	public function __construct() {
		$options = array(
			'exceptions' => true,
			'trace' => 1,
			'cache_wsdl' => 'WSDL_CACHE_NONE',
			'port' => 80,
			'soap_version' => 'SOAP_1_2',
			'location' => 'http://ws1/sms'
		);
		$this->client = new SoapClient('http://ws1/sms', $options);
	}

/**
* Use Client Soap to send messages.
*
* @param array $data
* @return boolean 
*
**/
	public function sendMessage($data) {
		$messages = $this->__prepareMessage($data);
		
		$parametersDefault = array(
			'compania' => '5', // Tween then send to a properly company.
			'pass' => 'atiliotest',
			'prioridad' => '1',
			'usuario' => 'atilio',
		);

		foreach ($messages as $message) {
			try {
				$message = array_merge($parametersDefault, $message);
				$response = $this->client->__soapCall('enviar', array('parameters' => $message));
				if (is_object($response)) {
					CakeLog::write('patients', $message['telefono'] . ' Codigo de respuesta: ' . $response->code);
				}
			}
			catch (SoapFault $e) {
				CakeLog::write('exceptionsWSDL', 'Error en el WDSL durante el envío: ' . $e);
				return false;
			}
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
					'mensaje' => $this->__convertToAscii($post[0]['text']) . "\n" . $this->__convertToAscii($v['Campaign']['signature']),
					'telefono' => $attribute['code'] . $attribute['cellular']
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
}