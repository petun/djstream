<?php
App::uses('AppModel', 'Model');
/**
 * TrackListen Model
 *
 * @property User $User
 * @property Track $Track
 */
class TrackListen extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'track_listen';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'track_id';

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
	
	public function findUsers($user_id,$type = 'list',$fields = array('id','track_id'),$order = array('id'=>'DESC')) {
		$conditions = array('user_id'=>$user_id);		
		$recursive = -1;
		$group = array('track_id');
		return $this->find($type,compact('conditions','fields','order','recursive','group'));
	}
}
