<?php
if (empty($patients)) {
	return;
}

echo $this->Html->scriptBlock(
<<<JS
$(function() {
	$(".checkall").click(function () {
		$('.single').prop('checked', this.checked);
	});

	$(".single").click(function(){
		if($(".single").length == $(".single:checked").length) {
			$("#checkall").prop("checked", "checked");
		} else {
			$("#checkall").removeAttr("checked");
		}
	});

	function getPatients(event) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url : this,
			data: {"CampaignsPatient": {campaign_id: $("#CampaignsPatientCampaignId").val()}},
			dataType: "html",
			success: function (response) {
				$('#patients').empty().append(response);
			}
		});	
	}

	$(".paging > span").children().bind("click", getPatients);
	$(".headers > th").children().bind("click", getPatients);
});
JS
);
?>
<table cellpadding="0" cellspacing="0" class="mtm">
	<tr class='headers'>
		<td><?= $this->Form->checkbox('checkall', array('class' => 'checkall'))?></td>
		<th><?= $this->Paginator->sort('name', __d('Patient', 'Name'))?></th>
		<th><?= $this->Paginator->sort('surname', __d('Patient', 'Surname'))?></th>
		<th><?= $this->Paginator->sort('cellular', __d('Patient', 'Code'))?></th>
		<th><?= $this->Paginator->sort('cellular', __d('Patient', 'Cellular'))?></th>
	</tr>
	<?php foreach ($patients as $patient):?>
	<tr>
		<td>
			<?= $this->Form->checkbox($patient['Patient']['id'], array(
				'name' => 'data[CampaignsPatient][patient_id][]', //. $patient['Patient']['id'] . "]",
				'value' => $patient['Patient']['id'],
				'type' => 'checkbox',
				'class' => 'single',
				'hiddenField' => false
			))?>
		</td>
		<td>
			<?=$this->Html->link($patient['Patient']['name'], array(
				'controller' => 'patients',
				'action' => 'view',
				$patient['Patient']['id']
			))?>
		</td>
		<td>
			<?= $this->Html->link($patient['Patient']['surname'], array(
				'controller' => 'patients',
				'action' => 'view',
				$patient['Patient']['id']
			))?>
		</td>
		<td>
			<?=$this->Html->link($patient['Patient']['code'], array(
				'controller' => 'patients',
				'action' => 'view',
				$patient['Patient']['id']
			))?>
		</td>
		<td>
			<?=$this->Html->link($patient['Patient']['cellular'], array(
				'controller' => 'patients',
				'action' => 'view',
				$patient['Patient']['id']
			))?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</p>