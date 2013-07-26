<div class="campaignsPatients form hero-unit">
<?= $this->Form->create('CampaignsPatient')?>
	<fieldset>
		<legend><?= __d('CampaignsPatient', 'Edit Campaigns Patient')?></legend>
		<?= $this->Form->input('id')?>
		<?= $this->Form->input('campaign_id', array('label' => __d('CampaignsPatient', 'Campaign')))?>
		<?= $this->Form->input('patient_id', array('label' => __d('CampaignsPatient', 'Pacientes')))?>
		<?= $this->Form->input('status', array('label' => __d('CampaignsPatient', 'Status')))?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>
