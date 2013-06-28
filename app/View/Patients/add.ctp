<?php

$cellular = '';
$code = '';
if (!empty($this->request->data['Patient']['cellular']) && $this->request->data['Patient']['code']) {
	$cellular = 'value=' . $this->request->data['Patient']['cellular'];
	$code = 'value=' . $this->request->data['Patient']['code'];
}

echo $this->element('timer');

?>
<div class="patients form hero-unit">
<?php echo $this->Form->create('Patient'); ?>
	<fieldset>
		<legend><?=__('Add Patient')?></legend>
		<?=$this->Form->input('name')?>
		<?=$this->Form->input('surname')?>
		<div class='controls'>
			<label class='span1'><?=__d('Patient', 'Code')?></label>
			<label class='span2'><?=__d('Patient', 'Cellular')?></label>
		</div>
		<div class='controls controls-row required'>
			<input name="data[Patient][code]" placeholder="0261" id="PatientCode" <?=$code?> class='span1' type='text'>
			<input name="data[Patient][cellular]" placeholder="153673809" id="PatientCellular" <?=$cellular?> class='span2' type='text'>
		</div>		
		<?=$this->Form->input('hour', array(
			'type' => 'text',
			'class' => 'span1'
		))?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>
