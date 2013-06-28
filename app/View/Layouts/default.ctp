<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __('SMS Cpanel');
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?=$cakeDescription?>:
		<?=$title_for_layout?>
	</title>
	<?=$this->Html->charset()?>
	<?=$this->Html->meta('icon')?>
	<?=$this->fetch('meta')?>

	<?=$this->Html->css(array(
		'cake.generic',
		'bootstrap/bootstrap',
		'general'
	))?>
	<?=$this->fetch('css')?>

	<?=$this->Html->script(array(
		'jquery/jquery-1.9.1',
		'jquery/jquery-ui-1.10.3.custom.min',
		'jquery/general',
		'bootstrap/bootstrap',
		'jquery/jquery.cluetip/jquery.cluetip.min',                             // complex tooltips
	))?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?=$this->element('navbar', array('authUser' => $authUser)); ?>
		</div>
		<div id="content">
			<div class="mbm"><?=$this->element('flash')?></div>
			<?=$this->fetch('content');?>
		</div>
		<div id="footer">
			
		</div>
	</div>
	<?=$this->fetch('script')?>
</body>
</html>
