<?=$this->element('calendar');?>
<div class="campaigns form hero-unit">
<?php echo $this->Form->create('Campaign'); ?>
	<fieldset>
		<legend><?php echo __('Add Campaign'); ?></legend>

		<?=$this->Form->input('name')?>
		<?=$this->Form->input('start_date', array(
			'id' => 'startDate',
			'type' => 'text',
			'class' => 'uneditable-input'
		))?>

		<?=$this->Form->input('end_date', array(
			'id' => 'endDate',
			'type' => 'text',
			'class' => 'uneditable-input'
		))?>
		<?=$this->Form->input('signature')?>
		<?=$this->Form->input('status')?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>
