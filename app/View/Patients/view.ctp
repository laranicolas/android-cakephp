<div class="patients view">
<h2><?= __d('Patient', 'Patient')?></h2>
	<dl class="dl-horizontal">
		<dt><?= __d('Patient', 'Id')?></dt>
		<dd>
			<?= h($patient['Patient']['id'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Patient', 'Name')?></dt>
		<dd>
			<?= h($patient['Patient']['name'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Patient', 'Surname')?></dt>
		<dd>
			<?= h($patient['Patient']['surname'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Patient', 'Code')?></dt>
		<dd>
			<?= h($patient['Patient']['code'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Patient', 'Cellular')?></dt>
		<dd>
			<?= h($patient['Patient']['cellular'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Patient', 'Hour')?></dt>
		<dd>
			<?= h($patient['Patient']['hour'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Patient', 'Created')?></dt>
		<dd>
			<?= h($patient['Patient']['created'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Patient', 'Modified')?></dt>
		<dd>
			<?= h($patient['Patient']['modified'])?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?= __d('CampaignsPatient', 'Related Campaigns Patients')?></h3>
	<?php if (!empty($patient['CampaignsPatient'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __d('CampaignsPatient', 'Id')?></th>
		<th><?= __d('CampaignsPatient', 'Campaign')?></th>
		<th><?= __d('CampaignsPatient', 'Patient')?></th>
		<th><?= __d('CampaignsPatient', 'Status')?></th>
		<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($patient['CampaignsPatient'] as $campaignsPatient): ?>
		<tr>
			<td><?= $campaignsPatient['id']?></td>
			<td><?= $campaignsPatient['Campaign']['name']?></td>
			<td><?= $patient['Patient']['name'] . ' ' . $patient['Patient']['surname']?></td>
			<td><?= ($campaignsPatient['status']) ? __d("Campaign", "Activate") : __d("Campaign", "Desactivate")?></td>
			<td class="actions">
				<?= 
					$this->Html->link(
						__('Edit'),
						array('controller' => 'campaigns_patients', 'action' => 'edit', $campaignsPatient['id']),
						array('class' => 'btn btn-success btn-small')
					)
				?>
				<?= 
					$this->Form->postLink(
						__('Delete'),
						array('controller' => 'campaigns_patients', 'action' => 'delete', $campaignsPatient['id']),
						array('class' => 'btn btn-danger btn-small'),
						__('Are you sure you want to delete # %s?', $campaignsPatient['id'])
					)
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	<div>
		<ul>
			<li>
				<?=$this->Html->link(__d('CampaignsPatient', 'New Campaigns Patient'), array(
					'controller' => 'campaigns_patients',
					'action' => 'add'
					), 
					array('class' => 'btn btn-small btn-primary')
				)?> 
			</li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?= __d('Sm', 'Sms')?></h3>
	<?php if (!empty($patient['Sm'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __d('CampaignsPatient', 'Id')?></th>
		<th><?= __d('CampaignsPatient', 'Patient')?></th>
		<th><?= __d('Sm', 'Mensaje')?></th>
		<th><?= __d('Sm', 'Horario de LLegada')?></th>
		<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($patient['Sm'] as $sm): ?>
		<tr>
			<td><?= $sm['id']?></td>
			<td><?= $patient['Patient']['name'] . ' ' . $patient['Patient']['surname']?></td>
			<td><?= $sm['text']?></td>
			<td><?= $sm['created']?></td>
			<td class="actions">
				<?=
					$this->Form->postLink(
						__('Delete'),
						array('controller' => 'sms', 'action' => 'delete', $sm['id']),
						array('class' => 'btn btn-danger btn-small'),
						__('Are you sure you want to delete # %s?', $sm['id'])
					)
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
