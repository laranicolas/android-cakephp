<?php

$cellular = '';
$code = '';

if (!empty($this->request->data['Patient']['cellular'])) {
	$cellular = 'value=' . $this->request->data['Patient']['cellular'];
}
if (!empty($this->request->data['Patient']['code'])) {
	$code = 'value=' . $this->request->data['Patient']['code'];
}

$hour = '12';
if (!empty($this->request->data['Patient']['hour'])) {
	$hour = $this->Time->format('H', $this->request->data['Patient']['hour']);
}

echo $this->element('timer');

?>
<div class="patients form hero-unit">
<?=$this->Form->create('Patient')?>
	<fieldset>
		<legend><?= __d('Patient', 'Edit Patient')?></legend>
		<?= $this->Form->input('id')?>
		<?= $this->Form->input('name', array(
			'label' => __d('Patient', 'Name'),
			'autocomplete' => 'off'
			)
		)?>
		<?= $this->Form->input('surname', array(
			'label' => __d('Patient', 'Surname'),
			'autocomplete' => 'off'
			)
		)?>

		<div class='controls controls-row required'>
			<label class='inline mrm'><?=__d('Patient', 'Code')?></label>
			<label class='inline mlxl'><?=__d('Patient', 'Cellular')?></label>
		</div>

		<div class='controls controls-row required'>
			<input name="data[Patient][code]" autocomplete="off" placeholder="261" id="PatientCode" <?=$code?> class='span1' type='text'>

			<p class='span0'>15</p>

			<input name="data[Patient][cellular]" autocomplete="off" placeholder="6123456" id="PatientCellular" <?=$cellular?> class='span2' type='text'>
			<?php if ($this->Form->isFieldError('code')) { echo $this->Form->error('code');}?>
			<?php if ($this->Form->isFieldError('cellular')) { echo $this->Form->error('cellular');}?>
		</div>

		<?= $this->Form->input('hour', array(
			'label' => __d('Patient', 'Hour'),
			'type' => 'text',
			'class' => 'span1',
			'value' => $hour,
			'autocomplete' => 'off'
			)
		)?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>