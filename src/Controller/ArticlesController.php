<?php
declare(strict_types=1);

namespace App\Controller;

class ArticlesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        // tags también es pública (no requiere login)
        $this->Authentication->allowUnauthenticated(['index', 'view', 'tags']);
    }

    public function index()
    {
        $this->Authorization->skipAuthorization();

        $articles = $this->Articles->find('all')
            ->contain(['Tags'])
            ->all();

        $this->set(compact('articles'));
    }

    public function view($slug = null)
    {
        $this->Authorization->skipAuthorization();

        $article = $this->Articles
            ->findBySlug($slug)
            ->contain(['Tags'])
            ->firstOrFail();

        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        $this->Authorization->authorize($article);

        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            $article->user_id = $this->request->getAttribute('identity')->getIdentifier();

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }

        $this->set(compact('article'));
    }

    public function edit($slug)
    {
        $article = $this->Articles
            ->findBySlug($slug)
            ->contain('Tags')
            ->firstOrFail();

        $this->Authorization->authorize($article);

        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData(), [
                'accessibleFields' => ['user_id' => false],
            ]);

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $this->set(compact('article'));
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->Authorization->authorize($article);

        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('Unable to delete the article.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function tags()
    {
        $this->Authorization->skipAuthorization();

        $tags = $this->request->getParam('pass');

        $articles = $this->Articles->find('tagged', tags: $tags)->all();

        $this->set([
            'articles' => $articles,
            'tags' => $tags,
        ]);
    }
}
