<?php
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class OpenidAuthenticate extends BaseAuthenticate {
    public function authenticate(CakeRequest $request, CakeResponse $response) {
        // Do things for openid here.

        // get request to perform
        //CakeLog::write('debug','Check token post data...');

        if (isset($request->data['token'])) {
            $token = $request->data['token'];
            CakeLog::write('debug','Token is ' . $token);

            // получаем профиль авторизованного пользователя
            $LoginzaAPI = new LoginzaAPI();
            $UserProfile = $LoginzaAPI->getAuthInfo($_POST['token']);

            // проверка на ошибки
            if (!empty($UserProfile->error_type)) {
                // есть ошибки, выводим их
                // в рабочем примере данные ошибки не следует выводить пользователю, так как они несут информационный характер только для разработчика
                CakeLog::write('debug',$UserProfile->error_type.": ".$UserProfile->error_message);
            } elseif (empty($UserProfile)) {
                // прочие ошибки
                CakeLog::write('debug', 'Temporary error.');
            } else {

                // если все хорошо, проверяем, нет ли такого пользователя в БД
                $LoginzaProfile = new LoginzaUserProfile($UserProfile);
                CakeLog::write('debug', print_r($UserProfile,true) );

                //
                $user_identity = $UserProfile->identity;
                $User = ClassRegistry::init('User');

                if (!$User->findByIdentity($user_identity)) {
                    $User->create();
                    $user_data = array(
                        'identity'=>$user_identity
                        ,'name'=>$LoginzaProfile->genFullName()
                        ,'password'=>$LoginzaProfile->genRandomPassword(6)
                        ,'is_blocked'=>0
                        ,'confirm_code'=>null
                    );

                    if (!$User->save($user_data)) {
                        return false;
                    } else {
                        CakeLog::write('debug', "User created: ".print_r($user_data,true));
                    }


                } else {
                    CakeLog::write('debug', "User with $user_identity identity exists");

                }

                $gUser = $User->findByIdentity($user_identity);
                CakeLog::write('debug', "return  ".print_r($gUser,true));
                return $gUser['User'];

            }




            //return array('username'=>'fucker','email'=>'fukc@mail.ru','name'=>'гыук');
        } else {
            //CakeLog::write('debug','Token not found');
            return false;
        }
    }
}


/**
 * Класс LoginzaUserProfile предназначен для генерации некоторых полей профиля пользователя сайта,
 * на основе полученного профиля от Loginza API (http://loginza.ru/api-overview).
 *
 * При генерации используются несколько полей данных, что позволяет сгенерировать непереданные
 * данные профиля, на основе имеющихся.
 *
 * Например: Если в профиле пользователя не передано значение nickname, то это значение может быть
 * сгенерированно на основе email или full_name полей.
 *
 * Данный класс - это рабочий пример, который можно использовать как есть,
 * а так же заимствовать в собственном коде или расширять текущую версию под свои задачи.
 *
 * @link http://loginza.ru/api-overview
 * @author Sergey Arsenichev, PRO-Technologies Ltd.
 * @version 1.0
 */
class LoginzaUserProfile {
    /**
     * Профиль
     *
     * @var unknown_type
     */
    private $profile;

    /**
     * Данные для транслита
     *
     * @var unknown_type
     */
    private $translate = array(
        'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ж'=>'g', 'з'=>'z',
        'и'=>'i', 'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p',
        'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'ы'=>'i', 'э'=>'e', 'А'=>'A',
        'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ж'=>'G', 'З'=>'Z', 'И'=>'I',
        'Й'=>'Y', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O', 'П'=>'P', 'Р'=>'R',
        'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Ы'=>'I', 'Э'=>'E', 'ё'=>"yo", 'х'=>"h",
        'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh", 'щ'=>"shch", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
        'Ё'=>"YO", 'Х'=>"H", 'Ц'=>"TS", 'Ч'=>"CH", 'Ш'=>"SH", 'Щ'=>"SHCH", 'Ъ'=>"", 'Ь'=>"",
        'Ю'=>"YU", 'Я'=>"YA"
    );

    function __construct($profile) {
        $this->profile = $profile;
    }

    public function genNickname () {
        if ($this->profile->nickname) {
            return $this->profile->nickname;
        } elseif (!empty($this->profile->email) && preg_match('/^(.+)\@/i', $this->profile->email, $nickname)) {
            return $nickname[1];
        } elseif ( ($fullname = $this->genFullName()) ) {
            return $this->normalize($fullname, '.');
        }
        // шаблоны по которым выцепляем ник из identity
        $patterns = array(
            '([^\.]+)\.ya\.ru',
            'openid\.mail\.ru\/[^\/]+\/([^\/?]+)',
            'openid\.yandex\.ru\/([^\/?]+)',
            '([^\.]+)\.myopenid\.com'
        );
        foreach ($patterns as $pattern) {
            if (preg_match('/^https?\:\/\/'.$pattern.'/i', $this->profile->identity, $result)) {
                return $result[1];
            }
        }

        return false;
    }

    public function genUserSite () {
        if (!empty($this->profile->web->blog)) {
            return $this->profile->web->blog;
        } elseif (!empty($this->profile->web->default)) {
            return $this->profile->web->default;
        }

        return $this->profile->identity;
    }

    public function genDisplayName () {
        if ( ($fullname = $this->genFullName()) ) {
            return $fullname;
        } elseif ( ($nickname = $this->genNickname()) ) {
            return $nickname;
        }

        $identity_component = parse_url($this->profile->identity);

        $result = $identity_component['host'];
        if ($identity_component['path'] != '/') {
            $result .= $identity_component['path'];
        }

        return $result.$identity_component['query'];

    }

    public function genFullName () {
        if ($this->profile->name->full_name) {
            return $this->profile->name->full_name;
        } elseif ( $this->profile->name->first_name || $this->profile->name->last_name ) {
            return trim($this->profile->name->first_name.' '.$this->profile->name->last_name);
        }

        return false;
    }
    /**
     * Генератор случайных паролей
     *
     * @param unknown_type $len Длина пароля
     * @param unknown_type $char_list Список наборов символов, используемых для генерации, через запятую. Например: a-z,0-9,~
     * @return unknown
     */
    public function genRandomPassword ($len=6, $char_list='a-z,0-9') {
        $chars = array();
        // предустановленные наборы символов
        $chars['a-z'] = 'qwertyuiopasdfghjklzxcvbnm';
        $chars['A-Z'] = strtoupper($chars['a-z']);
        $chars['0-9'] = '0123456789';
        $chars['~'] = '~!@#$%^&*()_+=-:";\'/\\?><,.|{}[]';

        // набор символов для генерации
        $charset = '';
        // пароль
        $password = '';

        if (!empty($char_list)) {
            $char_types = explode(',', $char_list);

            foreach ($char_types as $type) {
                if (array_key_exists($type, $chars)) {
                    $charset .= $chars[$type];
                } else {
                    $charset .= $type;
                }
            }
        }

        for ($i=0; $i<$len; $i++) {
            $password .= $charset[ rand(0, strlen($charset)-1) ];
        }

        return $password;
    }

    /**
     * Транслит + убирает все лишние символы заменяя на символ $delimer
     *
     * @param unknown_type $string
     * @param unknown_type $delimer
     * @return unknown
     */
    private function normalize ($string, $delimer='-') {
        $string = strtr($string, $this->translate);
        return trim(preg_replace('/[^\w]+/i', $delimer, $string), $delimer);
    }
}


/**
 * Класса работы с Loginza API (http://loginza.ru/api-overview).
 *
 * Данный класс - это рабочий пример, который можно использовать как есть,
 * а так же заимствовать в собственном коде или расширять текущую версию под свои задачи.
 *
 * Требуется PHP 5, а так же CURL или разрешение работы c ресурсами http:// для file_get_contents.
 *
 * @link http://loginza.ru/api-overview
 * @author Sergey Arsenichev, PRO-Technologies Ltd.
 * @version 1.0
 */
class LoginzaAPI {
    /**
     * Версия класса
     *
     */
    const VERSION = '1.0';
    /**
     * URL для взаимодействия с API loginza
     *
     */
    const API_URL = 'http://loginza.ru/api/%method%';
    /**
     * URL виджета Loginza
     *
     */
    const WIDGET_URL = 'https://loginza.ru/api/widget';

    /**
     * Получить информацию профиля авторизованного пользователя
     *
     * @param string $token Токен ключ авторизованного пользователя
     * @return mixed
     */
    public function getAuthInfo ($token) {
        return $this->apiRequert('authinfo', array('token' => $token));
    }

    /**
     * Получает адрес ссылки виджета Loginza
     *
     * @param string $return_url Ссылка возврата, куда будет возвращен пользователя после авторизации
     * @param string $provider Провайдер по умолчанию из списка: google, yandex, mailru, vkontakte, facebook, twitter, loginza, myopenid, webmoney, rambler, mailruapi:, flickr, verisign, aol
     * @param string $overlay Тип встраивания виджета: true, wp_plugin, loginza
     * @return string
     */
    public function getWidgetUrl ($return_url=null, $provider=null, $overlay='') {
        $params = array();

        if (!$return_url) {
            $params['token_url'] = $this->currentUrl();
        } else {
            $params['token_url'] = $return_url;
        }

        if ($provider) {
            $params['provider'] = $provider;
        }

        if ($overlay) {
            $params['overlay'] = $overlay;
        }

        return self::WIDGET_URL.'?'.http_build_query($params);
    }

    /**
     * Возвращает ссылку на текущую страницу
     *
     * @return string
     */
    private function currentUrl () {
        $url = array();
        // проверка https
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
            $url['sheme'] = "https";
            $url['port'] = '443';
        } else {
            $url['sheme'] = 'http';
            $url['port'] = '80';
        }
        // хост
        $url['host'] = $_SERVER['HTTP_HOST'];
        // если не стандартный порт
        if (strpos($url['host'], ':') === false && $_SERVER['SERVER_PORT'] != $url['port']) {
            $url['host'] .= ':'.$_SERVER['SERVER_PORT'];
        }
        // строка запроса
        if (isset($_SERVER['REQUEST_URI'])) {
            $url['request'] = $_SERVER['REQUEST_URI'];
        } else {
            $url['request'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
            $query = $_SERVER['QUERY_STRING'];
            if (isset($query)) {
                $url['request'] .= '?'.$query;
            }
        }

        return $url['sheme'].'://'.$url['host'].$url['request'];
    }

    /**
     * Делает запрос на API loginza
     *
     * @param string $method
     * @param array $params
     * @return string
     */
    private function apiRequert($method, $params) {
        // url запрос
        $url = str_replace('%method%', $method, self::API_URL).'?'.http_build_query($params);

        if ( function_exists('curl_init') ) {
            $curl = curl_init($url);
            $user_agent = 'LoginzaAPI'.self::VERSION.'/php'.phpversion();

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $raw_data = curl_exec($curl);
            curl_close($curl);
            $responce = $raw_data;
        } else {
            $responce = file_get_contents($url);
        }

        // обработка JSON ответа API
        return $this->decodeJSON($responce);
    }

    /**
     * Парсим JSON данные
     *
     * @param string $data
     * @return object
     */
    private function decodeJSON ($data) {
        if ( function_exists('json_decode') ) {
            return json_decode ($data);
        }

        // загружаем библиотеку работы с JSON если она необходима
        if (!class_exists('Services_JSON')) {
            require_once( dirname( __FILE__ ) . '/JSON.php' );
        }

        $json = new Services_JSON();
        return $json->decode($data);
    }

    public function debugPrint ($responceData, $recursive=false) {
        if (!$recursive){
            echo "<h3>Debug print:</h3>";
        }
        echo "<table border>";
        foreach ($responceData as $key => $value) {
            if (!is_array($value) && !is_object($value)) {
                echo "<tr><td>$key</td> <td><b>$value</b></td></tr>";
            } else {
                echo "<tr><td>$key</td> <td>";
                $this->debugPrint($value, true);
                echo "</td></tr>";
            }
        }
        echo "</table>";
    }
}