<?php
/**
 * Render a login User screen.
 *
 */
?>

<div class="login-box mtl">
	<h4><?=__('SMS Panel')?></h4>
	<?=$this->Form->create('User', array(
		'id' => 'UserLoginForm',
		'url' => array('action' => 'login'),
		'class' => 'well form-inline'
	))?>
		<?=$this->Form->input('username', array(
			'div' => false,
			'placeholder' => __d('User', 'username'),
			'label' => false,
			'class' => 'input-medium',
			'autocomplete' => 'off'
		))?>
		<?=$this->Form->input('password', array(
			'div' => false,
			'placeholder' => __d('User', 'password'),
			'label' => false,
			'class' => 'mlm input-medium',
			'autocomplete' => 'off',
			'value' => ''
		))?>
		<?=$this->Form->submit(__d('User', 'Sign in'), array(
			'div' => false,
			'class' => 'mlm btn btn-medium btn-info'
		))?>
	<?=$this->Form->end()?>
</div>
<div class='hero-unit' style="width: 182px; margin: 50px auto;">
	<?=$this->Html->image('Isologotipo.png', array('class' => 'img-rounded'))?>
</div>