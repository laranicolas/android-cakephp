<?php
echo $this->Html->css(array('jquery/smoothness/jquery-ui-1.10.3.custom.min'));
echo $this->Html->script(array('jquery/jquery.datepicker/l10n/jquery.ui.datepicker-es'));

$action = router::url(array('controller' => 'posts', 'action' => 'availableDates'), true);
$jsaction = json_encode($action);

$imageUrl = $this->request->webroot . 'img/calendar2.gif';
$jsimageUrl = json_encode($imageUrl);

echo $this->Html->scriptBlock(
<<<JS
$(function() {
	$("#PostCampaignId").on("change", function () {
		now = new Date();
		today = $.datepicker.formatDate("dd/mm/yy", now);
		today = $.datepicker.parseDate("dd/mm/yy", today);

		$.ajax({
			type: "POST",
			url : {$jsaction},
			data: {"Post": {campaign_id: $("#PostCampaignId").val()}},
			dataType: "json",
			success: function (response) {
				$("#startDate").datepicker("destroy");
				$("#startDate").datepicker({
					minDate: response.start_date,
					maxDate: response.end_date,
					showOn: "button",
					buttonImage: {$jsimageUrl},
					buttonImageOnly: true,
					beforeShowDay: function (date) {
						var dmy = date;
						var dmyString = $.datepicker.formatDate("dd/mm/yy", dmy);

						if (
							$.inArray(dmyString, response.unavailable_dates) < 0
							&& (dmy >= $.datepicker.parseDate("dd/mm/yy", response.start_date)
							&& dmy <= $.datepicker.parseDate("dd/mm/yy", response.end_date)
							&& dmy.valueOf() >= today.valueOf())
						)
						{
							return [true,"enabled", "Disponible"];
						} else {
							return [false,"disabled", "No Disponible"];
						}
					}
				});
			}
		});	
	});

	$("#PostCampaignId").trigger("change");
});
JS
);?>
