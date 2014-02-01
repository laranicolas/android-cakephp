<div class="groups view">
<h2><?= __d('Group', 'Group')?></h2>
	<dl class="dl-horizontal">
		<dt><?= __d('Group', 'Id')?></dt>
		<dd>
			<?= h($group['Group']['id'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Group', 'Name')?></dt>
		<dd>
			<?= h($group['Group']['name'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Group', 'Created')?></dt>
		<dd>
			<?= h($group['Group']['created'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Group', 'Modified')?></dt>
		<dd>
			<?= h($group['Group']['modified'])?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?= __d('User', 'Related Users')?></h3>
	<?php if (!empty($group['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __d('User', 'Id')?></th>
		<th><?= __d('User', 'Username')?></th>
		<th><?= __d('User', 'Password')?></th>
		<th><?= __d('User', 'Group Id')?></th>
		<th><?= __d('User', 'Created')?></th>
		<th><?= __d('User', 'Modified')?></th>
		<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($group['User'] as $user): ?>
		<tr>
			<td><?= $user['id']?></td>
			<td><?= $user['username']?></td>
			<td><?= $user['password']?></td>
			<td><?= $user['group_id']?></td>
			<td><?= $user['created']?></td>
			<td><?= $user['modified']?></td>
			<td class="actions">
				<?= 
					$this->Html->link(
						__('Edit'),
						array('controller' => 'users', 'action' => 'edit', $user['id']),
						array('class' => 'btn btn-success btn-small')
					)
				?>
				<?= 
					$this->Form->postLink(
						__('Delete'),
						array('controller' => 'users', 'action' => 'delete', $user['id']),
						array('class' => 'btn btn-danger btn-small'),
						__('Are you sure you want to delete # %s?', $user['id'])
					)
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	<div>
		<ul>
			<li><?= $this->Html->link(__d('User', 'New User'), array('controller' => 'users', 'action' => 'add'), array('class' => 'btn btn-small btn-primary'))?> </li>
		</ul>
	</div>
</div>
