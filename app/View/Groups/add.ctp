<div class="groups form hero-unit">
	<?= $this->Form->create('Group')?>
		<fieldset>
			<legend><?= __d('Group', 'Add Group')?></legend>
			<?= $this->Form->input('name', array(
				'label' => __d('Group', 'Name'),
				'autocomplete' => 'off'
				)
			)?>
		</fieldset>
	<?=$this->Form->end(__('Submit'))?>
</div>
