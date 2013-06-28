<?php
echo $this->Html->css(array(
	'jquery/smoothness/jquery-ui-1.10.3.custom.min',
	'jquery/jquery.timepicker/jquery-ui-timepicker-addon'
));
echo $this->Html->script(array(
	'jquery/jquery.timepicker/jquery-ui-timepicker-addon.min',
	'jquery/jquery.timepicker/l10n/jquery-ui-timepicker-es',
));

echo $this->Html->scriptBlock(
<<<JS
$(function() {
	$( "#PatientHour").timepicker({
		showMinute: false,
		stepHour: 4,
		hourMin: 8,
		hourMax: 20,
		hourGrid: 4
	});
});
JS
);
?>