<?php
/**
 * AppShell file
 *
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @author 		  Lara Nicolás
 */

class SmsShell extends AppShell {
	public $uses = array('Patient');

    public function main() {
        $patient = $this->Patient->find('all');
        $this->out(print_r($patient, true));
    }
}