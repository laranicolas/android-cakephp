<div class="campaigns view">
<h2><?= __('Campaign')?></h2>
	<dl class="dl-horizontal">
		<dt><?= __('Id')?></dt>
		<dd>
			<?= h($campaign['Campaign']['id'])?>
			&nbsp;
		</dd>
		<dt><?= __('Name')?></dt>
		<dd>
			<?= h($campaign['Campaign']['name'])?>
			&nbsp;
		</dd>
		<dt><?= __('Start Date')?></dt>
		<dd>
			<?= h($campaign['Campaign']['start_date'])?>
			&nbsp;
		</dd>
		<dt><?= __('End Date')?></dt>
		<dd>
			<?= h($campaign['Campaign']['end_date'])?>
			&nbsp;
		</dd>
		<dt><?= __('Status')?></dt>
		<dd>
			<?=h($campaign['Campaign']['status']) ? __d("Campaign", "Activate") : __d("Campaign", "Desactivate")?>
			&nbsp;
		</dd>
		<dt><?= __('Signature')?></dt>
		<dd>
			<?= h($campaign['Campaign']['signature'])?>
			&nbsp;
		</dd>
		<dt><?= __('Created')?></dt>
		<dd>
			<?= h($campaign['Campaign']['created'])?>
			&nbsp;
		</dd>
		<dt><?= __('Modified')?></dt>
		<dd>
			<?= h($campaign['Campaign']['modified'])?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?= __('Related Posts')?></h3>
	<?php if (!empty($campaign['Post'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __('Id')?></th>
		<th><?= __('Text')?></th>
		<th><?= __('start_date')?></th>
		<th><?= __('Created')?></th>
		<th><?= __('Modified')?></th>
		<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($campaign['Post'] as $post): ?>
		<tr>
			<td><?= $post['id']?></td>
			<td><?= substr($post['text'], 0 , 10)?></td>
			<td><?= $post['start_date']?></td>
			<td><?= $post['created']?></td>
			<td><?= $post['modified']?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $post['id']))?>
				<?= $this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $post['id']))?>
				<?= $this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $post['id']), null, __('Are you sure you want to delete # %s?', $post['id']))?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	<div>
		<ul>
			<li>
				<?=$this->Html->link(__('New Post'), array(
					'controller' => 'posts',
					'action' => 'add'),
					array('class' => 'btn btn-small btn-primary')
				)?>
			</li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?= __('Related Campaigns Patients')?></h3>
	<?php if (!empty($campaign['CampaignsPatient'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __('Id')?></th>
		<th><?= __('Patient Id')?></th>
		<th><?= __('status')?></th>
		<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($campaign['CampaignsPatient'] as $campaignsPatient): ?>
		<tr>
			<td><?= $campaignsPatient['id']; ?></td>
			<td><?= $campaignsPatient['Patient']['name'] . ' ' . $campaignsPatient['Patient']['surname'] ?></td>
			<td><?=($campaignsPatient['status']) ? __d("Campaign", "Activate") : __d("Campaign", "Desactivate")?></td>
			<td class="actions">
				<?= $this->Html->link(__('Edit'), array('controller' => 'campaigns_patients', 'action' => 'edit', $campaignsPatient['id']))?>
				<?= $this->Form->postLink(__('Delete'), array('controller' => 'campaigns_patients', 'action' => 'delete', $campaignsPatient['id']), null, __('Are you sure you want to delete # %s?', $campaignsPatient['id']))?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	<div>
		<ul>
			<li>
				<?=$this->Html->link(__('New Campaigns Patient'), array(
					'controller' => 'campaigns_patients',
					'action' => 'add'
					), 
					array('class' => 'btn btn-small btn-primary')
				)?> 
			</li>
		</ul>
	</div>
</div>
