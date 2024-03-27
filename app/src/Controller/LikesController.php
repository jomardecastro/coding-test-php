<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Likes Controller
 *
 * @method \App\Model\Entity\Like[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LikesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Auth');

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $likes = $this->paginate($this->Likes);
        $this->set(compact('likes'));

    }

    /**
     * View method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $like = $this->Likes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('like'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $response = ['success' => false, 'message' => 'The like could not be saved. Please, try again.'];
        $insert['user_id'] = $this->Auth->user('id');
        $insert['article_id'] = $this->request->getData('article_id');
        $like = $this->Likes->newEmptyEntity();
        if ($this->request->is('post')) 
        {
            $like = $this->Likes->patchEntity($like, $insert);
            if ($this->Likes->save($like)) 
            {
                $response = ['success' => true, 'message' => 'The like has been saved.'];
            }
            else 
            {
                $errors = $like->getErrors();
                $errorMessages = [];
                foreach($errors as $field => $error){
                    $errorMessages[] = $field .': '. array_pop($error);
                }
                $response = [
                    'success' => false
                ];
                $response['message'] = implode(' ', $errorMessages);
            }
        }
        else 
        {
            $response = [
                'success' => false,
                'message' => 'Invalid request method.',
            ];
        }
        
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }

    /**
     * Edit method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $like = $this->Likes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $like = $this->Likes->patchEntity($like, $this->request->getData());
            if ($this->Likes->save($like)) {
                $this->Flash->success(__('The like has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The like could not be saved. Please, try again.'));
        }
        $this->set(compact('like'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $like = $this->Likes->get($id);
        if ($this->Likes->delete($like)) {
            $this->Flash->success(__('The like has been deleted.'));
        } else {
            $this->Flash->error(__('The like could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
