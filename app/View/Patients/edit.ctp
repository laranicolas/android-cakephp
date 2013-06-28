<?php

$cellular = '';
$code = '';
if (
	!empty($this->request->data['Patient']['cellular']) 
	&& !empty($this->request->data['Patient']['code'])
) {
	$cellular = 'value=' . $this->request->data['Patient']['cellular'];
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
		<legend><?php echo __('Edit Patient'); ?></legend>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('name');
			echo $this->Form->input('surname');
		?>
<!-- 		<div class='controls required'>
			<label class='span1'><?=__d('Patient', 'Code')?></label>
			<label class='span2'><?=__d('Patient', 'Cellular')?></label>
			</div> -->
		
			<?=$this->Form->input('code', array(
				'type' => 'text',
				'class' => 'span1'
				// 'div' => false,
				// 'label' => false
			))?>
			<?=$this->Form->input('cellular', array(
				'type' => 'text',
				'class' => 'span2',
			))?>
		
		<?=$this->Form->input('hour', array(
			'type' => 'text',
			'class' => 'span1',
			'value' => $hour
		))?>
	</fieldset>
<?=$this->Form->end(__('Submit'))?>
</div>