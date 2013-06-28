<!doctype html>
<html>
<head>
	<title><?=__('SMS Cpanel')?></title>
	<?=$this->Html->charset()?>
	<?=$this->Html->meta('icon')?>
	<?=$this->fetch('meta')?>
	<?=$this->Html->css(array(
		'general',
		'bootstrap/bootstrap'
	))?>
	<?=$this->fetch('script')?>
</head>
<body>
	<?=$this->element('flash')?>
	<div class="container">
		<?=$this->fetch('content')?>
	</div>
	<?=$this->Html->script(array(
	'jquery/jquery-1.9.1',
		'jquery/jquery-ui-1.10.3.custom.min',
		'jquery/general',
		'bootstrap/bootstrap',
		'jquery/jquery.cluetip/jquery.cluetip.min',                             // complex tooltips
	))?>
</body>
</html>
