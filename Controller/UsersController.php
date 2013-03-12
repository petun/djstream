<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
*/
class UsersController extends AppController {
    public $scaffold = 'admin';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('registration','success','logout','confirm','forgot')); // Letting users register themselves
    }
    
    public function login() {
        // title
        $this->set('title_for_layout','Вход');

        // редирект, если авторизован и прется
        if ($this->Auth->loggedIn()) {
            $this->redirect($this->Auth->redirect());
        }
        
        
        $this->layout = 'login';
        
         
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Auth->loggedIn() || $this->Auth->login()) {                
                CakeLog::info('Пользователь успешно вошел.','user');                            
                $this->redirect($this->Auth->redirect());                
            } else {                
                CakeLog::warning('Пользователь не вошел.','user');                
            }
               
        }
    }
        
    
    public function logout() {
        //CakeLog::write('debug','[USER]: do logout. user: '.$this->Auth->user('id'));
        CakeLog::info('Пользователь вышел.','user');            
        $this->redirect($this->Auth->logout());
    }
   

    public function profile() {
        //layout
        $this->layout = '2cols';
        // title
        $this->set('title_for_layout','Ваш профиль');       
        $user =  $this->User->findCurrent();
        $this->set('user',$user);

        if ($this->request->is('post') || $this->request->is('put') ) {           

            $this->User->id = $this->Auth->user('id');

            if ($this->User->save($this->request->data)) {
                //CakeLog::write('debug','Saving user data OK - Userid: '.$this->Auth->user('id'));
                CakeLog::info('Профиль успешно обновлен.','user');
                $this->Session->setFlash('Профиль успешно обновлен');               
            }
        } else {            
            $this->request->data = $user;
        }

    }
       

    
   


}
