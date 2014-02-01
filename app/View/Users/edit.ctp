<div class="users form hero-unit">
<?= $this->Form->create('User')?>
	<fieldset>
		<legend><?= __d('User', 'Edit User')?></legend>
		<?= $this->Form->input('id')?>
		<?= $this->Form->input('username', array(
			'label' => __d('User', 'Username'),
			'autocomplete' => 'off'
			)
		)?>
		<?= $this->Form->input('password', array(
			'label' => __d('User', 'Password'),
			'autocomplete' => 'off'
			)
		)?>
		<?= $this->Form->input('changePassword', array(
			'autocomplete' => 'off',
			'type' => 'password'
			)
		)?>
		<?= $this->Form->input('group_id', array('label' => __d('User', 'Group')))?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>