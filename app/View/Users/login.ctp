<?php
/**
 * Render a login User screen.
 *
 */
?>

<div class="login-box mtl">
	<h4><?=__('SMS panel')?></h4>
	<?=$this->Form->create('User', array(
		'id' => 'UserLoginForm',
		'url' => array('action' => 'login'),
		'class' => 'well form-inline'
	))?>
		<?=$this->Form->input('username', array(
			'div' => false,
			'placeholder' => __d('user', 'username'),
			'label' => false,
			'class' => 'input-medium',
			'autocomplete' => 'off'
		))?>
		<?=$this->Form->input('password', array(
			'div' => false,
			'placeholder' => __d('user', 'password'),
			'label' => false,
			'class' => 'input-medium',
			'autocomplete' => 'off',
			'value' => ''
		))?>
		<?=$this->Form->submit(__('Sign in'), array(
			'div' => false,
			'class' => 'btn'
		))?>
	<?=$this->Form->end()?>
</div>
<div class='hero-unit' style="width: 600px; margin: 50px auto;">
	<?=$this->Html->image('SMS.jpg', array('class' => 'img-rounded'))?>
</div>