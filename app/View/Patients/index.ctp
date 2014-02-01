<div class="patients index">
	<div>
		<ul>
			<li><h2><?= __d('Patient', 'Patients')?></h2></li>
			<li><?= $this->Html->link(__d('Patient', 'New Patient'), array('controller' => 'patients', 'action' => 'add'), array('class' => 'btn btn-primary btn-mini'))?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?= $this->Paginator->sort('id', __d('Patient', 'Id'))?></th>
			<th><?= $this->Paginator->sort('name', __d('Patient', 'Name'))?></th>
			<th><?= $this->Paginator->sort('surname', __d('Patient', 'Surname'))?></th>
			<th><?= $this->Paginator->sort('code', __d('Patient', 'Code'))?></th>
			<th><?= $this->Paginator->sort('cellular', __d('Patient', 'Cellular'))?></th>
			<th><?= $this->Paginator->sort('hour', __d('Patient', 'Hour'))?></th>
			<th><?= $this->Paginator->sort('created', __d('Patient', 'Created'))?></th>
			<th><?= $this->Paginator->sort('modified', __d('Patient', 'Modified'))?></th>
			<th class="actions"><?= __('Actions')?></th>
	</tr>
	<?php foreach ($patients as $patient): ?>
	<tr>
		<td><?= h($patient['Patient']['id'])?>&nbsp;</td>
		<td><?= h($patient['Patient']['name'])?>&nbsp;</td>
		<td><?= h($patient['Patient']['surname'])?>&nbsp;</td>
		<td><?= h($patient['Patient']['code'])?>&nbsp;</td>
		<td><?= h($patient['Patient']['cellular'])?>&nbsp;</td>
		<td><?= h($patient['Patient']['hour'])?>&nbsp;</td>
		<td><?= h($patient['Patient']['created'])?>&nbsp;</td>
		<td><?= h($patient['Patient']['modified'])?>&nbsp;</td>
		<td class="actions">
			<?= 
				$this->Html->link(
					__('View'), 
					array('action' => 'view', $patient['Patient']['id']),
					array('class' => 'btn btn-success btn-small')
				)
			?>
			<?= 
				$this->Html->link(
					__('Edit'),
					array('action' => 'edit', $patient['Patient']['id']),
					array('class' => 'btn btn-success btn-small')	
				)
			?>
			<?= 
				$this->Form->postLink(
					__('Delete'), array('action' => 'delete', $patient['Patient']['id']),
					array('class' => 'btn btn-danger btn-small'),
					__('Are you sure you want to delete # %s?', $patient['Patient']['id'])
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