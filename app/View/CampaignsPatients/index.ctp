<div class="campaignsPatients index">
	<div>
		<ul>
			<li><h2><?= __d('CampaignsPatient', 'Campaigns Patients')?></h2></li>
			<li><?= $this->Html->link(__d('CampaignsPatient', 'New Campaign Patient'), array('controller' => 'campaignsPatients', 'action' => 'add'), array('class' => 'btn btn-primary btn-mini'))?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?= $this->Paginator->sort('id', __d('CampaignsPatient', 'Id'))?></th>
			<th><?= $this->Paginator->sort('campaign_id', __d('CampaignsPatient', 'Campaign'))?></th>
			<th><?= $this->Paginator->sort('patient_id', __d('CampaignsPatient', 'Patient'))?></th>
			<th><?= $this->Paginator->sort('status', __d('CampaignsPatient', 'Status'))?></th>
			<th class="actions"><?= __('Actions')?></th>
	</tr>

	<?php foreach ($campaignsPatients as $campaignsPatient): ?>
	<tr>
		<td><?= h($campaignsPatient['CampaignsPatient']['id'])?>&nbsp;</td>
		<td>
			<?= $this->Html->link($campaignsPatient['Campaign']['name'], array('controller' => 'campaigns', 'action' => 'view', $campaignsPatient['Campaign']['id']))?>
		</td>
		<td>
			<?= 
				$this->Html->link($campaignsPatient['Patient']['name'] . ' ' . $campaignsPatient['Patient']['surname'], array('controller' => 'patients', 'action' => 'view', $campaignsPatient['Patient']['id']))
			?>
		</td>
		<td>
			<?=($campaignsPatient['CampaignsPatient']['status']) ? __d("Campaign", "Activate") : __d("Campaign", "Desactivate")?>&nbsp;
		</td>

		<td class="actions">
			<?= 
				$this->Html->link(
					__('Edit'),
					array('action' => 'edit', $campaignsPatient['CampaignsPatient']['id']),
					array('class' => 'btn btn-success btn-small')	
				)
			?>
			<?= 
				$this->Form->postLink(
					__('Delete'), array('action' => 'delete', $campaignsPatient['CampaignsPatient']['id']),
					array('class' => 'btn btn-danger btn-small'),
					__('Are you sure you want to delete # %s?', $campaignsPatient['CampaignsPatient']['id'])
				)
			?>
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
</div>