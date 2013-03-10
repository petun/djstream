<?php
App::uses('AppController', 'Controller');
/**
 * Tracks Controller
 *
 * @property Track $Track
 */
class TracksController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		
		$conditions = array();
		$recursive = 0;
		$limit = 30;		
		
		
		if (isset($this->request->query['source_id']) && is_array($this->request->query['source_id'])) {
			$conditions['source_id'] = $this->request->query['source_id'];
			
			$ids = $this->request->query['source_id'];$this->request->query['source_id'] = array();
			foreach ($ids as $id) {
				$this->request->query['source_id'][] = (int)$id;
			}
		}
		
		if (isset($this->request->query['genre_id']) && is_array($this->request->query['genre_id'])) {
			$conditions['genre_id'] = $this->request->query['genre_id'];
			
			$ids = $this->request->query['genre_id'];$this->request->query['genre_id'] = array();
			
			
			foreach ($ids as $id) {
				$this->request->query['genre_id'][] = (int)$id;
			}
		}
		
		
		
		
		/*if ($this->request->query['genre_id']) {
			$conditions['genre_id'] = $this->request->query['genre_id'];
		}*/
		
		
		$criteria = compact('conditions','recursive','limit');
		
		
		
		$this->set('tracks', $this->Track->find('all',$criteria));
		
		//
		$sources = $this->Track->Source->find('list');
		$genres = $this->Track->Genre->find('list');
		
		$this->set(compact('sources','genres'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Track->exists($id)) {
			throw new NotFoundException(__('Invalid track'));
		}
		$options = array('conditions' => array('Track.' . $this->Track->primaryKey => $id));
		$this->set('track', $this->Track->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Track->create();
			if ($this->Track->save($this->request->data)) {
				$this->Session->setFlash(__('The track has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The track could not be saved. Please, try again.'));
			}
		}
		$sources = $this->Track->Source->find('list');
		$genres = $this->Track->Genre->find('list');
		$this->set(compact('sources', 'genres'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Track->exists($id)) {
			throw new NotFoundException(__('Invalid track'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Track->save($this->request->data)) {
				$this->Session->setFlash(__('The track has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The track could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Track.' . $this->Track->primaryKey => $id));
			$this->request->data = $this->Track->find('first', $options);
		}
		$sources = $this->Track->Source->find('list');
		$genres = $this->Track->Genre->find('list');
		$this->set(compact('sources', 'genres'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Track->id = $id;
		if (!$this->Track->exists()) {
			throw new NotFoundException(__('Invalid track'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Track->delete()) {
			$this->Session->setFlash(__('Track deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Track was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
