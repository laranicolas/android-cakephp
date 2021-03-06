<?php

$action = router::url(array('controller' => 'campaignsPatients', 'action' => 'ajax_searchPatients'), true);
$jsaction = json_encode($action);

echo $this->Html->scriptBlock(
<<<JS
$(function() {
	$("#CampaignsPatientCampaignId").on("change", function () {
		$.ajax({
			type: "POST",
			url : {$jsaction},
			data: {"CampaignsPatient": {campaign_id: $("#CampaignsPatientCampaignId").val()}},
			dataType: "html",
			success: function (response) {
				$('#patients').empty().append(response);
			}
		});	
	})
	
	$("#CampaignsPatientCampaignId").trigger("change");
})
JS
);
?>
<div class="campaignsPatients form">
<?=$this->Form->create('CampaignsPatient')?>
	<fieldset>
		<legend><?= __d('CampaignsPatient', 'Add Campaigns Patient')?></legend>
		<?=$this->Form->input('campaign_id', array('label' => __d('CampaignsPatient', 'Campaign')))?>
		<div id="patients">
		</div>		
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>
