<?php
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

/**
 * An authentication adapter for AuthComponent.  Provides the ability to authenticate using COOKIE
 *
 * {{{
 *	$this->Auth->authenticate = array(
 *		'Authenticate.Cookie' => array(
 *			'fields' => array(
 *				'username' => 'username',
 *				'password' => 'password'
 *	 		),
 *			'userModel' => 'User',
 *			'scope' => array('User.active' => 1),
 *			'crypt' => 'rijndael'// Defaults to rijndael(safest), optionally set to 'cipher' if required
 *		)
 *	)
 * }}}
 *
 */
class CookieAuthenticate extends BaseAuthenticate {

/**
 * Authenticates the identity contained in the cookie.  Will use the `settings.userModel`, and `settings.fields`
 * to find COOKIE data that is used to find a matching record in the `settings.userModel`.  Will return false if
 * there is no cookie data, either username or password is missing, of if the scope conditions have not been met.
 *
 * @param CakeRequest $request The unused request object
 * @param CakeResponse $response Unused response object.
 * @return mixed.  False on login failure.  An array of User data on success.
 */
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		if (!isset($this->_Collection->Cookie) || !$this->_Collection->Cookie instanceof CookieComponent) {
			throw new CakeException('CookieComponent is not loaded');
		}

		$this->settings = array_merge(array('crypt' => 'rijndael'), $this->settings);
		if ($this->settings['crypt'] == 'rijndael' && !function_exists('mcrypt_encrypt')) {
			throw new CakeException('Cannot use type rijndael, mcrypt_encrypt() is required');
		}
		
		
		
		$this->_Collection->Cookie->type($this->settings['crypt']);

		list(, $model) = pluginSplit($this->settings['userModel']);

		$data = $this->_Collection->Cookie->read($model);
		
		//CakeLog::write('debug', "CookieAuth Call - data is ".print_r($data,true));
		
		if (empty($data)) {
			return false;
		}

		extract($this->settings['fields']);
		if (empty($data[$username]) || empty($data[$password])) {
			return false;
		}
		
		//CakeLog::write('debug', "[AuthCookie]: Success auth for user: ".$data[$username]);		
		$r =  $this->_findUser($data[$username], $data[$password]);
		if ($r) {
			CakeLog::info("Пользователь авторизовался через cookie. ".$data[$username].'. UserID: '.$r['id'],'user');
		}

		return $r;
	}

}
