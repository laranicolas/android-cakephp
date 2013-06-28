<div class="campaignsPatients index">
	<div>
		<ul>
			<li><h2><?php echo __('Campaigns Patients'); ?></h2></li>
			<li><?php echo $this->Html->link(__('New Campaign Patient'), array('controller' => 'campaignsPatients', 'action' => 'add'), array('class' => 'btn btn-primary btn-mini')); ?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('campaign_id'); ?></th>
			<th><?php echo $this->Paginator->sort('patient_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>

	<?php foreach ($campaignsPatients as $campaignsPatient): ?>
	<tr>
		<td><?php echo h($campaignsPatient['CampaignsPatient']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($campaignsPatient['Campaign']['name'], array('controller' => 'campaigns', 'action' => 'view', $campaignsPatient['Campaign']['id'])); ?>
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
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $campaignsPatient['CampaignsPatient']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $campaignsPatient['CampaignsPatient']['id']), null, __('Are you sure you want to delete # %s?', $campaignsPatient['CampaignsPatient']['id'])); ?>
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