<div class="users form hero-unit">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('group_id');
	?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>