<?php
$messages = $this->Session->read('Message');
if (!$messages) {
	return;
}
foreach (array_keys($messages) as $key) {
	echo $this->Session->flash($key);
}