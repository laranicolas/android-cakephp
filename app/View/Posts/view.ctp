<div class="posts view">
<h2><?php  echo __('Post'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($post['Post']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Campaign'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['Campaign']['name'], array('controller' => 'campaigns', 'action' => 'view', $post['Campaign']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Text'); ?></dt>
		<dd>
			<?php echo h($post['Post']['text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('start_date'); ?></dt>
		<dd>
			<?php echo h($post['Post']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($post['Post']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($post['Post']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
