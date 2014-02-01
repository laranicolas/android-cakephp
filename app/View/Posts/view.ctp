<div class="posts view">
<h2><?= __d('Post', 'Post')?></h2>
	<dl class="dl-horizontal">
		<dt><?= __d('Post', 'Id')?></dt>
		<dd>
			<?= h($post['Post']['id'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Post', 'Campaign')?></dt>
		<dd>
			<?= $this->Html->link($post['Campaign']['name'], array('controller' => 'campaigns', 'action' => 'view', $post['Campaign']['id']))?>
			&nbsp;
		</dd>
		<dt><?= __d('Post', 'Text')?></dt>
		<dd>
			<?= h($post['Post']['text'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Post', 'start_date')?></dt>
		<dd>
			<?= h($post['Post']['start_date'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Post', 'Created')?></dt>
		<dd>
			<?= h($post['Post']['created'])?>
			&nbsp;
		</dd>
		<dt><?= __d('Post', 'Modified')?></dt>
		<dd>
			<?= h($post['Post']['modified'])?>
			&nbsp;
		</dd>
	</dl>
</div>
