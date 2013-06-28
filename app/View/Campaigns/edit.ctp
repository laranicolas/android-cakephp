<?=$this->element('calendar');?>
<div class="campaigns form hero-unit">
<?php echo $this->Form->create('Campaign'); ?>
	<fieldset>
		<legend><?php echo __('Edit Campaign'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('start_date', array(
			'id' => 'startDate',
			'type' => 'text'
		));
		echo $this->Form->input('end_date', array(
			'id' => 'endDate',
			'type' => 'text'	
		));
		echo $this->Form->input('signature');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>