<div class="patients index">
	<div>
		<ul>
			<li><h2><?php echo __('Patients'); ?></h2></li>
			<li><?php echo $this->Html->link(__('New Patient'), array('controller' => 'patients', 'action' => 'add'), array('class' => 'btn btn-primary btn-mini')); ?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('surname'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('cellular'); ?></th>
			<th><?php echo $this->Paginator->sort('hour'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($patients as $patient): ?>
	<tr>
		<td><?php echo h($patient['Patient']['id']); ?>&nbsp;</td>
		<td><?php echo h($patient['Patient']['name']); ?>&nbsp;</td>
		<td><?php echo h($patient['Patient']['surname']); ?>&nbsp;</td>
		<td><?php echo h($patient['Patient']['code']); ?>&nbsp;</td>
		<td><?php echo h($patient['Patient']['cellular']); ?>&nbsp;</td>
		<td><?php echo h($patient['Patient']['hour']); ?>&nbsp;</td>
		<td><?php echo h($patient['Patient']['created']); ?>&nbsp;</td>
		<td><?php echo h($patient['Patient']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $patient['Patient']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $patient['Patient']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $patient['Patient']['id']), null, __('Are you sure you want to delete # %s?', $patient['Patient']['id'])); ?>
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