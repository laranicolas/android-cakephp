	<div class="campaigns view">
<h2><?= __d('Campaign', 'Campaign')?></h2>
	<dl class="dl-horizontal">
		<dt><?= __d('Campaign', 'Id')?></dt>
		<dd>
			<?= h($campaign['Campaign']['id'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Campaign', 'Name')?></dt>
		<dd>
			<?= h($campaign['Campaign']['name'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Campaign', 'Start Date')?></dt>
		<dd>
			<?= h($campaign['Campaign']['start_date'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Campaign', 'End Date')?></dt>
		<dd>
			<?= h($campaign['Campaign']['end_date'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Campaign', 'Status')?></dt>
		<dd>
			<?=h($campaign['Campaign']['status']) ? __d("Campaign", "Activate") : __d("Campaign", "Desactivate")?>
			&nbsp;
		</dd>
		<dt><?= __d('Campaign', 'Signature')?></dt>
		<dd>
			<?= h($campaign['Campaign']['signature'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Campaign', 'Created')?></dt>
		<dd>
			<?= h($campaign['Campaign']['created'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Campaign', 'Modified')?></dt>
		<dd>
			<?= h($campaign['Campaign']['modified'])?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?= __d('Post', 'Related Posts')?></h3>
	<?php if (!empty($campaign['Post'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __d('Post', 'Id')?></th>
		<th><?= __d('Post', 'Text')?></th>
		<th><?= __d('Post', 'start_date')?></th>
		<th><?= __d('Post', 'Created')?></th>
		<th><?= __d('Post', 'Modified')?></th>
		<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($campaign['Post'] as $post): ?>
		<tr>
			<td><?= $post['id']?></td>
			<td><?= substr($post['text'], 0 , 20) . '...' ?></td>
			<td><?= $post['start_date']?></td>
			<td><?= $post['created']?></td>
			<td><?= $post['modified']?></td>
			<td class="actions">
			<?= 
				$this->Html->link(
					__('View'),
					array('controller' => 'posts', 'action' => 'view',$post['id']),
					array('class' => 'btn btn-success btn-small')
				)
			?>
			<?= 
				$this->Html->link(
					__('Edit'),
					array('controller' => 'posts', 'action' => 'edit', $post['id']),
					array('class' => 'btn btn-success btn-small')
				)
			?>
			<?= 
				$this->Form->postLink(
					__('Delete'),
					array('controller' => 'posts', 'action' => 'delete', $post['id']),
					array('class' => 'btn btn-danger btn-small'),
					__('Are you sure you want to delete # %s?', $post['id'])
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
				<?=$this->Html->link(__d('Post', 'New Post'), array(
					'controller' => 'posts',
					'action' => 'add'),
					array('class' => 'btn btn-small btn-primary')
				)?>
			</li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?= __d('CampaignsPatient', 'Related Campaigns Patients')?></h3>
	<?php if (!empty($campaign['CampaignsPatient'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __d('CampaignsPatient', 'Id')?></th>
		<th><?= __d('CampaignsPatient', 'Patient')?></th>
		<th><?= __d('CampaignsPatient', 'Status')?></th>
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
