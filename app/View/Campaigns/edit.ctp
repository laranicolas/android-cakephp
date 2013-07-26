<?=$this->element('calendar')?>
<div class="campaigns form hero-unit">
	<?= $this->Form->create('Campaign')?>
		<fieldset>
			<legend><?= __d('Campaign', 'Edit Campaign')?></legend>
		
			<?= $this->Form->input('id')?>
			
			<?= $this->Form->input('name', array(
				'label' => __d('Campaign', 'Name'),
				'autocomplete' => 'off'
				)
			)?>
			
			<?= $this->Form->input('start_date', array(
				'label' => __d('Campaign', 'Start Date'),
				'id' => 'startDate',
				'type' => 'text',
				'autocomplete' => 'off'
			))?>
			
			<?= $this->Form->input('end_date', array(
				'label' => __d('Campaign', 'End Date'),
				'id' => 'endDate',
				'type' => 'text',
				'autocomplete' => 'off'
			))?>
			
			<?= $this->Form->input('signature', array(
				'label' => __d('Campaign', 'Signature'),
				'autocomplete' => 'off'
				)
			)?>
			
			<?= $this->Form->input('status', array('label' => __d('Campaign', 'Status')))?>
		</fieldset>
	<?=$this->Form->end(__('Submit'))?>
</div>