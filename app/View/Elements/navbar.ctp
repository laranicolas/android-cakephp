<?php
/**
 * Render a menu for cpanel users.
 *
 */
if (empty($authUser)) {
	return;
}

if (!empty($authUser['first_name']) && !empty($authUser['last_name'])) {
	$userInfo = uw($authUser['first_name'].' '.$authUser['last_name']);
}
$userInfo = ' ('.$authUser['Group']['name'].')';

$loggedUser = '<span class="bold ttt">'.$authUser['username'] . $userInfo .'</span>';

$tabset = array(
	'Administrador' => array(
		'Groups' => array(
			'name' => __('Groups'),
			'controller' => 'groups',
			'action' => 'index'
		),
		'Users' => array(
			'name' => __('Users'),
			'controller' => 'users',
			'action' => 'index'
		),
		'Patients' => array(
			'name' => __('Patients'),
			'controller' => 'patients',
			'action' => 'index'
		),
		'Campaigns' => array(
			'name' => __('Campaigns'),
			'controller' => 'campaigns',
			'action' => 'index'
		),
		'CampaignsPatients' => array(
			'name' => __('CampaignsPatients'),
			'controller' => 'campaignsPatients',
			'action' => 'index'
		),
		'Posts' => array(
			'name' => __('Posts'),
			'controller' => 'posts',
			'action' => 'index'
		)
	),
	'Moderador' => array(
		'Patients' => array(
			'name' => __('Patients'),
			'controller' => 'patients',
			'action' => 'index'
		),
		'Campaigns' => array(
			'name' => __('Campaigns'),
			'controller' => 'campaigns',
			'action' => 'index'
		),
		'CampaignsPatients' => array(
			'name' => __('CampaignsPatients'),
			'controller' => 'campaignsPatients',
			'action' => 'index'
		),
		'Posts' => array(
			'name' => __('Posts'),
			'controller' => 'posts',
			'action' => 'index'
		)		
	),
	'Usuario' => array(
		'Patients' => array(
			'name' => __('Patients'),
			'controller' => 'patients',
			'action' => 'index'
		),
		'Campaigns' => array(
			'name' => __('Campaigns'),
			'controller' => 'campaigns',
			'action' => 'index'
		),
		'CampaignsPatients' => array(
			'name' => __('CampaignsPatients'),
			'controller' => 'campaignsPatients',
			'action' => 'index'
		),
		'Posts' => array(
			'name' => __('Posts'),
			'controller' => 'posts',
			'action' => 'index'
		)		
	)
);

$controllers = array();
if (!empty($tabset[$authUser['Group']['name']])) {
	$controllers = $tabset[$authUser['Group']['name']];
}

$actions = array();
foreach ($controllers as &$c) {
	if ($this->request->params['controller'] == $c['controller']) {
		$c['active'] = true;
		if (!empty($c['actions'])) {
			foreach ($c['actions'] as &$a) {
				if ($this->request->params['action'] == $a['action']) {
					$a['active'] = true;
				}
				$a['controller'] = $c['controller'];
			}
			unset($a);
		}
	}
}
unset($c);

$home['active'] = false;
if ($this->request['controller'] == 'pages' && $this->request['action'] == 'display' && $this->request['pass'][0] == 'home') {
	$home['active'] = true;
}

?>
<div class="navbar navbar-fixed-top navbar-inverse">
	<div class="navbar-inner">
		<ul class="nav nav-pills">
			<li class="<?= !empty($home['active']) ? 'active' : ''?>">
				<?=$this->Html->link(
					__('Home'),
					array('controller' => 'pages', 'action' => 'display', 'home')
				)?>
			</li>
			<?php foreach ($controllers as $c): ?>
				<?php if (!empty($c['actions'])): ?>
					<li class="dropdown <?= !empty($c['active']) ? 'active' : '' ?>">
						<?=$this->Html->link(
							$c['name'].'<b class="caret"></b>',
							'#',
							array(
								'class' => 'dropdown-toggle',
								'data-toggle' => 'dropdown',
								'escape' => false
							)
						)?>
						<ul class="dropdown-menu">
							<?php foreach ($c['actions'] as $a): ?>
								<li class="<?= !empty($a['active']) ? 'active' : ''?>">
									<?=$this->Html->link(
										$a['name'],
										array('controller' => $c['controller'], 'action' => $a['action'])
									)?>
								</li>
							<?php endforeach; ?>
						</ul>
					</li>
				<?php else: ?>
					<li class="<?= !empty($c['active']) ? 'active' : ''?>">
						<?=$this->Html->link(
							$c['name'],
							array('controller' => $c['controller'], 'action' => $c['action'])
						)?>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<ul class="nav pull-right">
			<li><a href="#"><?=$loggedUser?></a></li>
			<li class="active">
				<?=$this->Html->link(__d('user', 'Logout'), '/logout')?>
			</li>
		</ul>
	</div>
</div>
