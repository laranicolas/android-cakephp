<?php
echo $this->Html->css(array('jquery/smoothness/jquery-ui-1.10.3.custom.min'));
echo $this->Html->script(array('jquery/jquery.datepicker/l10n/jquery.ui.datepicker-es'));

$imageUrl = $this->request->webroot . 'app/webroot/img/calendar2.gif';
$jsimageUrl = json_encode($imageUrl);

echo $this->Html->scriptBlock(
<<<JS
$(function() {
	now = new Date();
	today = $.datepicker.formatDate("dd/mm/yy", now);
	today = $.datepicker.parseDate("dd/mm/yy", today);

	$( "#startDate").datepicker({
		minDate: today,
		showOn: "button",
		buttonImage: {$jsimageUrl},
		buttonImageOnly: true,
		onClose: function( selectedDate ) {
			$( "#endDate" ).datepicker("option", "minDate", selectedDate);
			if (!selectedDate) {
				$( "#endDate" ).datepicker("option", "minDate", today);
			}
			$( "#endDate" ).datepicker( "show" );
		}
	});

	$( "#endDate" ).datepicker({
		showOn: "button",
		buttonImage: {$jsimageUrl},
		buttonImageOnly: true,
		beforeShow: function() {
			if (!$('#startDate').val()) {
				$( "#endDate" ).datepicker("option", "minDate", today);
			}	
		},
		onClose: function( selectedDate ) {
			$( "#startDate" ).datepicker("option", "maxDate", selectedDate);
		}
	});
});
JS
);
?>