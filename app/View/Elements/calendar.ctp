<?php
echo $this->Html->css(array('jquery/smoothness/jquery-ui-1.10.3.custom.min'));
echo $this->Html->script(array('jquery/jquery.datepicker/l10n/jquery.ui.datepicker-es'));

$imageUrl = $this->request->webroot . 'app/webroot/img/calendar2.gif';
$jsimageUrl = json_encode($imageUrl);

echo $this->Html->scriptBlock(
<<<JS
$(function() {
	$( "#startDate").datepicker({
		showOn: "button",
		buttonImage: {$jsimageUrl},
		buttonImageOnly: true,
		onClose: function( selectedDate ) {
			$( "#endDate" ).datepicker("option", "minDate", selectedDate);
			$( "#endDate" ).datepicker( "show" );
		}
	});

	$( "#endDate" ).datepicker({
		showOn: "button",
		buttonImage: {$jsimageUrl},
		buttonImageOnly: true,
		onClose: function( selectedDate ) {
			$( "#startDate" ).datepicker("option", "maxDate", selectedDate);			
		}
	});
});
JS
);
?>