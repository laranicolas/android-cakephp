<?=$this->element('ajax_calendar')?>

<div class="posts form hero-unit">
	<?=$this->Form->create('Post')?>
		<fieldset>
			<legend><?= __d('Post', 'Add Post')?></legend>
			<?= $this->Form->input('campaign_id', array(
				'label' => __d('Post', 'Campaign'),
				'autocomplete' => 'off'
				)
			)?>
			<?= $this->Form->input('text', array(
				'label' => __d('Post', 'Text'),
				'autocomplete' => 'off'
				)
			)?>
			<?= $this->Form->input('start_date', array(
				'label' => __d('Post', 'start_date'),
				'id' => 'startDate',
				'type' => 'text',
				'autocomplete' => 'off'
				)
			)?>
		</fieldset>
	<?=$this->Form->end(__('Submit'))?>
</div>
