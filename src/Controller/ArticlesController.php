<?php

namespace App\Controller;

/**
* 
*/
class ArticlesController extends AppController{

	public function isAuthorized($user){
		if ($this->request->getParam('action') === 'add') {
			return true;
		}

		if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
			$articleId = (int)$this->request->getParam('pass.0');
			if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}
	
	public function index(){
		$articles = $this->Articles->find('all');
		$this->set(compact('articles'));
	}

	public function view($id = null){
		$article = $this->Articles->get($id);
		$this->set(compact('article'));
	}

	public function add(){
		$article = $this->Articles->newEntity();
		if ($this->request->is('post')) {
			$article = $this->Articles->patchEntity($article, $this->request->getData());
			$article->user_id = $this->Auth->user('id');
			if ($this->Articles->save($article)) {
				$this->Flash->success(__('Your article has ben saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to add your article.'));
		}
		$this->set('article', $article);
	}

	public function edit($id = null){
		$article = $this->Articles->get($id);
		if ($this->request->is(['post', 'put'])) {
			$this->Articles->patchEntity($article, $this->request->getData());
			if ($this->Articles->save($article)) {
				$this->Flash->success(__('Tu articulo ha sido actualizado.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Tu articulo no se ha podido actualizar'));
		}
		$this->set('article', $article);
	}

	public function delete($id){
		$this->request->allowMethod(['post','delete']);

		$article = $this->Articles->get($id);
		if ($this->Articles->delete($article)) {
			$this->Flash->success(__('El articulo con id: {0} ha sido eliminado', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}
}