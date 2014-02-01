<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {

	public $paginate = array(
		'limit' => 10,
		'order' => array(
		'Post.start_date' => 'desc'
		)
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Post->recursive = 0;
		$posts = $this->paginate();
		foreach ($posts as $k => $v) {
			if (isset($v['Post']['text'])) {
				$posts[$k]['Post']['text'] = $this->_truncate($v['Post']['text'], 25);
			}
		}
		$this->set(compact('posts'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__d('Post', 'Invalid post'));
		}
		$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
		$this->set('post', $this->Post->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__d('Post', 'The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('Post', 'The post could not be saved. Please, try again.'));
			}
		}
		$campaigns = $this->Post->Campaign->find('list');
		$this->set(compact('campaigns'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__d('Post', 'Invalid post'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__d('Post', 'The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('Post', 'The post could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
			$this->request->data = $this->Post->find('first', $options);
		}
		$campaigns = $this->Post->Campaign->find('list');
		$this->set(compact('campaigns'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__d('Post', 'Invalid post'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Post->delete()) {
			$this->Session->setFlash(__d('Post', 'Post deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__d('Post', 'Post was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
* Obtain valid range date for Posts (AJAX).
*
* @param
* @return array()
*/
	public function availableDates() {
		if (!$this->request->is('post')) {
			return;
		}

		$campaignId = $this->request->data['Post']['campaign_id'];

		$response = $this->Post->Campaign->findById($campaignId);
		if (empty($response)) {
			return;
		}

		$unavailableDates = array();
		foreach ($response['Post'] as $v) {
			$unavailableDates[] .= $v['start_date'];
		}

		$rangeDate = array(
			'start_date' => $response['Campaign']['start_date'],
			'end_date' => $response['Campaign']['end_date'],
			'unavailable_dates' => $unavailableDates
		);

		$this->autoRender = false;
		return json_encode($rangeDate);
	}
}
