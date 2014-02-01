<div class="groups index">
	<div>
		<ul>
			<li><h2><?= __d('Group', 'Groups')?></h2></li>
			<li><?= $this->Html->link(__d('Group', 'New Group'), array('controller' => 'groups', 'action' => 'add'), array('class' => 'btn btn-primary btn-mini'))?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?= $this->Paginator->sort('id')?></th>
		<th><?= $this->Paginator->sort('name', __d('Group', 'Name'))?></th>
		<th><?= $this->Paginator->sort('created', __d('Group', 'Created'))?></th>
		<th><?= $this->Paginator->sort('modified', __d('Group', 'Modified'))?></th>
		<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php foreach ($groups as $group): ?>
	<tr>
		<td><?= h($group['Group']['id'])?>&nbsp;</td>
		<td><?= h($group['Group']['name'])?>&nbsp;</td>
		<td><?= h($group['Group']['created'])?>&nbsp;</td>
		<td><?= h($group['Group']['modified'])?>&nbsp;</td>
		<td class="actions">
			<?= 
				$this->Html->link(
					__('View'), 
					array('action' => 'view', $group['Group']['id']),
					array('class' => 'btn btn-success btn-small')
				)
			?>
			<?= 
				$this->Html->link(
					__('Edit'),
					array('action' => 'edit', $group['Group']['id']),
					array('class' => 'btn btn-success btn-small')	
				)
			?>
			<?= 
				$this->Form->postLink(
					__('Delete'), array('action' => 'delete', $group['Group']['id']),
					array('class' => 'btn btn-danger btn-small'),
					__('Are you sure you want to delete # %s?', $group['Group']['id'])
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