<div class="campaigns index">
	<div>
		<ul>
			<li><h2><?= __d('Campaign', 'Campaigns')?></h2></li>
			<li><?= $this->Html->link(__d('Campaign', 'New Campaign'), array('controller' => 'campaigns', 'action' => 'add'), array('class' => 'btn btn-primary btn-mini'))?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?= $this->Paginator->sort('id', __d('Campaign', 'Id'))?></th>
			<th><?= $this->Paginator->sort('name', __d('Campaign', 'Name'))?></th>
			<th><?= $this->Paginator->sort('start_date', __d('Campaign', 'start_date'))?></th>
			<th><?= $this->Paginator->sort('end_date', __d('Campaign', 'end_date'))?></th>
			<th><?= $this->Paginator->sort('status', __d('Campaign', 'Status'))?></th>
			<th><?= $this->Paginator->sort('signature', __d('Campaign', 'Signature'))?></th>
			<th><?= $this->Paginator->sort('created', __d('Campaign', 'Created'))?></th>
			<th><?= $this->Paginator->sort('modified', __d('Campaign', 'Modified'))?></th>
			<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php foreach ($campaigns as $campaign): ?>
	<tr>
		<td><?= h($campaign['Campaign']['id'])?>&nbsp;</td>
		<td><?= h($campaign['Campaign']['name'])?>&nbsp;</td>
		<td><?= h($campaign['Campaign']['start_date'])?>&nbsp;</td>
		<td><?= h($campaign['Campaign']['end_date'])?>&nbsp;</td>
		<td><?=($campaign['Campaign']['status']) ? __d("Campaign", "Activate") : __d("Campaign", "Desactivate")?>&nbsp;</td>
		<td><?= h($campaign['Campaign']['signature'])?>&nbsp;</td>
		<td><?= h($campaign['Campaign']['created'])?>&nbsp;</td>
		<td><?= h($campaign['Campaign']['modified'])?>&nbsp;</td>
		<td class="actions">
			<?= 
				$this->Html->link(
					__('View'), 
					array('action' => 'view', $campaign['Campaign']['id']),
					array('class' => 'btn btn-success btn-small')
				)
			?>
			<?= 
				$this->Html->link(
					__('Edit'),
					array('action' => 'edit', $campaign['Campaign']['id']),
					array('class' => 'btn btn-success btn-small')	
				)
			?>
			<?= 
				$this->Form->postLink(
					__('Delete'), array('action' => 'delete', $campaign['Campaign']['id']),
					array('class' => 'btn btn-danger btn-small'),
					__('Are you sure you want to delete # %s?', $campaign['Campaign']['id'])
				)
			?>
		</td>
	</tr>
<?php endforeach;?>
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