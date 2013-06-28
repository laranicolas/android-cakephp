<div class="campaignsPatients form hero-unit">
<?php echo $this->Form->create('CampaignsPatient'); ?>
	<fieldset>
		<legend><?php echo __('Edit Campaigns Patient'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('campaign_id');
		echo $this->Form->input('patient_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>
