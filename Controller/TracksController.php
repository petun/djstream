<?php
App::uses('AppController', 'Controller');
/**
 * Tracks Controller
 *
 * @property Track $Track
 */
class TracksController extends AppController {

	public $helpers = array('Ru','Zippy');
/**
 * index method
 *
 * @return void
 */
	public function index() {			
		$conditions = array();
		$recursive = 0;
		$limit = 30;		
		$order = array('created'=>'DESC');
		
		$this->set('title_for_layout','Треки');
		
		// criterias
		if (isset($this->request->query['source_id']) && is_array($this->request->query['source_id'])) {
			$conditions['source_id'] = $this->request->query['source_id'];
		}
		
		if (isset($this->request->query['genre_id']) && is_array($this->request->query['genre_id'])) {
			$conditions['genre_id'] = $this->request->query['genre_id'];
		}

		// fav criteria
		$favorites = array();
		if (isset($this->request->query['favorite']) && !empty($this->request->query['favorite'])) {
			if ($this->Auth->user('id')) {
				$favorites = $this->Track->UserFavorite->findUsers($this->Auth->user('id'));
				$conditions['Track.id'] = $favorites;
			}
		}
		$this->set('favorites',$favorites);
		
		// listened tracks
		$listened = array();
		if ($this->Auth->user('id')) {
			$listened = $this->Track->TrackListen->findUsers($this->Auth->user('id'));			
		}
		$this->set(array('listened'=>$listened));


		// from track - for ajax autoload
		if (isset($this->request->query['from_track'])) {
			$conditions['Track.id <'] = $this->request->query['from_track'];
		}
		
				
		
		$criteria = compact('conditions','recursive','limit','order');

		$count =  $this->Track->find('count',array('conditions'=>$conditions,'recursive'=>-1));
		$this->set('count', $count );

		$this->set('tracks', $this->Track->find('all',$criteria));
		
		
	}
	
	public function set_status($id,$status) {
		if (!$this->Track->exists($id)) {
			throw new NotFoundException(__('Invalid track'));
		}

		$r = false;
		
		if ($status == 'listen') {
			$data = array('track_id'=>$id);
			if ($this->Auth->user('id')) {
				$data['user_id'] = $this->Auth->user('id');
			}
			
			CakeLog::info('Add listened track : '.print_r($data,true));
			
			$r = $this->Track->TrackListen->save($data);
		} else if ($status == 'favorite') {
			$exists = $this->Track->UserFavorite->isUserFavorite($this->Auth->user('id'),$id);
			
			if ($exists) {
				CakeLog::info('Delete favorite track');
				$this->Track->UserFavorite->delete($exists);				
			} else {
				$data = array('user_id'=>$this->Auth->user('id'),'track_id'=>$id);
				CakeLog::info('Add favorite track : '.print_r($data,true));
				$r = (bool)$this->Track->UserFavorite->save($data);				
			}

		}
		
		$this->set('r',$r);
	}

	public function download($id) {
		if (!$this->Track->exists($id)) {
			throw new NotFoundException(__('Invalid track'));
		}

		$track = $this->Track->read(null,$id);

		// add to history
		$data['track_id'] = $id;
		if ($this->Auth->user('id')) {
			$data['user_id'] = $this->Auth->user('id');
		}
		$this->Track->TrackDownload->save($data);

		// redirect
		$this->redirect($track['Track']['url']);
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
		
		$track = $this->Track->read(null,$id);
		$this->set('title_for_layout',$track['Track']['artist'] . ' - '. $track['Track']['song']);
					
		$this->set('track', $track);
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
