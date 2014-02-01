<div class="posts index">
	<div>
		<ul>
			<li><h2><?= __d('Post', 'Posts')?></h2></li>
			<li><?= $this->Html->link(__d('Post', 'New Post'), array('controller' => 'posts', 'action' => 'add'), array('class' => 'btn btn-primary btn-mini'))?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?= $this->Paginator->sort('id', __d('Post', 'id'))?></th>
			<th><?= $this->Paginator->sort('campaign_id', __d('Post', 'Campaign'))?></th>
			<th><?= $this->Paginator->sort('text', __d('Post', 'Text'))?></th>
			<th><?= $this->Paginator->sort('start_date', __d('Post', 'start_date'))?></th>
			<th><?= $this->Paginator->sort('created', __d('Post', 'Created'))?></th>
			<th><?= $this->Paginator->sort('modified', __d('Post', 'Modified'))?></th>
			<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php foreach ($posts as $post): ?>
	<tr>
		<td><?= h($post['Post']['id'])?>&nbsp;</td>
		<td>
			<?= $this->Html->link($post['Campaign']['name'], array('controller' => 'campaigns', 'action' => 'view', $post['Campaign']['id']))?>
		</td>
		<td><?= h($post['Post']['text'])?>&nbsp;</td>
		<td><?= h($post['Post']['start_date'])?>&nbsp;</td>
		<td><?= h($post['Post']['created'])?>&nbsp;</td>
		<td><?= h($post['Post']['modified'])?>&nbsp;</td>
		<td class="actions">
			<?= 
				$this->Html->link(
					__('View'),
					array('action' => 'view', $post['Post']['id']),
					array('class' => 'btn btn-success btn-small')	
				)
			?>
			<?= 
				$this->Html->link(
					__('Edit'),
					array('action' => 'edit', $post['Post']['id']),
					array('class' => 'btn btn-success btn-small')	
				)
			?>
			<?= 
				$this->Form->postLink(
					__('Delete'), array('action' => 'delete', $post['Post']['id']),
					array('class' => 'btn btn-danger btn-small'),
					__('Are you sure you want to delete # %s?', $post['Post']['id'])
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