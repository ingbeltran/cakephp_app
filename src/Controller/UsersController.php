<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFounException;

class UsersController extends AppController{
	
	public function beforeFilter(Event $event){
		parent::beforeFilter($event);
		$this->Auth->allow('add');
	}

	public function index(){
		$this->set('users', $this->Users->find('all'));
	}

	public function view($id){
		if (!id) {
			throw new NotFounException(__('Invalid user'));
		}

		$user = $this->Users->get($id);
		$this->set(compact('user'));
	}

	public function add(){
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Teh user has been saved'));
				return $this->redirect(['action' => 'add']);
			}
			$this->Flash->error(__('Unable to add the user'));
		}
		$this->set('user', $user);
	}
}