<?=$this->element('ajax_calendar');?>	
<div class="posts form hero-unit">
<?=$this->Form->create('Post');?>
	<fieldset>
		<legend><?php echo __('Edit Post'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('campaign_id');
		echo $this->Form->input('text');
		echo $this->Form->input('start_date', array(
			'id' => 'startDate',
			'type' => 'text'
		));
	?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>