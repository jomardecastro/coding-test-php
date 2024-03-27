<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Articles Controller
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $articles = $this->paginate($this->Articles);
        $user = $this->Auth->user();
        $this->viewBuilder()->setOption('serialize', ['articles', 'user']);
        $this->set(compact('articles', 'user'));
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => [],
        ]);
        $this->viewBuilder()->setOption('serialize', ['article']);
        $this->set(compact('article'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
            $article = $this->Articles->newEmptyEntity();
            if ($this->request->is('post')) 
            {
                $insert['title'] = $this->request->getData('title');
                $insert['body'] = $this->request->getData('body');
                $insert['user_id'] = $this->Auth->user('id');
                $article = $this->Articles->patchEntity($article, $insert);
                if ($this->Articles->save($article)) 
                {
                    $this->Flash->success(__('The article has been saved.'));

                    $response = [
                        'success' => true,
                        'message' => 'The article has been saved.',
                        'data' => $article,
                    ];
                }
                else
                {
                    $response = [
                        'success' => false,
                        'message' => 'The article could not be saved. Please, try again.',
                        'errors' => $article->getErrors(),
                    ];
                }
            }
            else 
            {
                $response = [
                    'success' => false,
                    'message' => 'Invalid request method.',
                ];
            }
        $this->set('article', $article);
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) 
            {
                $response = [
                    'success' => true,
                    'message' => 'The article has been saved.',
                    'data' => $article,
                ];
            }
            
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }

        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }

        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

}
