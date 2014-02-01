<div class="groups form hero-unit">
	<?= $this->Form->create('Group')?>
		<fieldset>
			<legend><?= __d('Group', 'Edit Group')?></legend>
			<?= $this->Form->input('id')?>
			<?= $this->Form->input('name', array(
				'label' => __d('Group', 'Name'),
				'autocomplete' => 'off'
				)
			)?>
		</fieldset>
	<?=$this->Form->end(__('Submit'))?>
</div>
