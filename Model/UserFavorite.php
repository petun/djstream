<?php
App::uses('AppModel', 'Model');
/**
 * UserFavorite Model
 *
 * @property User $User
 * @property Track $Track
 */
class UserFavorite extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'track_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Track' => array(
			'className' => 'Track',
			'foreignKey' => 'track_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function isUserFavorite($user_id,$track_id) {
		$conditions = array('user_id'=>$user_id,'track_id'=>$track_id);
		$el = $this->find('first',compact('conditions'));
		if ($el) {
			return $el['UserFavorite']['id'];
		} else {
			return false;
		}
	}

	public function findUsers($user_id) {
		$conditions = array('user_id'=>$user_id);
		$fields = array('UserFavorite.id','track_id');
		return $this->find('list',  compact('conditions','fields'));
	}

}
