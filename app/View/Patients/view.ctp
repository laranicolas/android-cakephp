<div class="patients view">
<h2><?php  echo __('Patient')?></h2>
	<dl class="dl-horizontal">
		<dt><?= __('Id')?></dt>
		<dd>
			<?= h($patient['Patient']['id'])?>
			&nbsp;
		</dd>
		<dt><?= __('Name')?></dt>
		<dd>
			<?= h($patient['Patient']['name'])?>
			&nbsp;
		</dd>
		<dt><?= __('Surname')?></dt>
		<dd>
			<?= h($patient['Patient']['surname'])?>
			&nbsp;
		</dd>
		<dt><?= __('Code')?></dt>
		<dd>
			<?= h($patient['Patient']['code'])?>
			&nbsp;
		</dd>
		<dt><?= __('Cellular')?></dt>
		<dd>
			<?= h($patient['Patient']['cellular'])?>
			&nbsp;
		</dd>
		<dt><?= __('Hour')?></dt>
		<dd>
			<?= h($patient['Patient']['hour'])?>
			&nbsp;
		</dd>
		<dt><?= __('Created')?></dt>
		<dd>
			<?= h($patient['Patient']['created'])?>
			&nbsp;
		</dd>
		<dt><?= __('Modified')?></dt>
		<dd>
			<?= h($patient['Patient']['modified'])?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?= __('Related Campaigns Patients')?></h3>
	<?php if (!empty($patient['CampaignsPatient'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __('Id')?></th>
		<th><?= __('Campaign')?></th>
		<th><?= __('Patient')?></th>
		<th><?= __('status')?></th>
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
				<?= $this->Html->link(__('Edit'), array('controller' => 'campaigns_patients', 'action' => 'edit', $campaignsPatient['id']))?>
				<?= $this->Form->postLink(__('Delete'), array('controller' => 'campaigns_patients', 'action' => 'delete', $campaignsPatient['id']), null, __('Are you sure you want to delete # %s?', $campaignsPatient['id']))?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
