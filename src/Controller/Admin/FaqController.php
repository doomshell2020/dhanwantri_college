<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Routing\Router;
class FaqController extends AppController
{
    

    public function index()
    {
       
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Faq');
        $this->loadModel('FaqCategory');
        $result = $this->Faq->find('all')->contain('FaqCategory')->order(['Faq.id'=>'DESC'])->toarray();
        
        $this->set(compact(['result']));
    }


    public function add()
    {
        $this->loadModel('Faq');
        $this->loadModel('FaqCategory');
        $this->viewBuilder()->layout('admin');
        $users = $this->FaqCategory->find('list', [
            'keyField' => 'id',
            'valueField' => 'category_name'
        ])->where(['FaqCategory.status'=>'Y'])->toArray();
        $this->set(compact(['users']));
        
        if ($this->request->is('post')) {
            $faq = $this->Faq->newEntity();
            $faq['faq_question'] = ucwords(strtolower($this->request->data['faq_question']));
            $faq['faq_answer'] = ucwords(strtolower($this->request->data['faq_answer']));
            $faq['category_id'] = $this->request->data['category_id'];

            if ($this->request->data['image']['tmp_name']) {
                $ext = pathinfo($this->request->data['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . "." . $ext;
                $path = "faq_images/" . $filename;
                move_uploaded_file($this->request->data['image']['tmp_name'], $path);
                $this->request->data['image'] = $filename;
                $faq['image']  = $filename;
               
            }
            $this->Faq->save($faq);
            $this->Flash->success(__('Faq Successfully Saved.'));
            return $this->redirect(['action' => 'index']);
        }

    }

    public function edit($id)
    {
        $this->loadModel('Faq');
        $this->loadModel('FaqCategory');
        $this->viewBuilder()->layout('admin');       
        
        $FaqCategory = $this->FaqCategory->find('list', [
            'keyField' => 'id',
            'valueField' => 'category_name'
            ])->where(['FaqCategory.status'=>'Y'])->toArray();
            $this->set('FaqCategory', $FaqCategory);
            
            $faq = $this->Faq->find('all')->where(['id' => $id])->first();
            $this->set(compact(['faq']));
       
        if ($this->request->is(['post', 'put'])) {
            $faq['faq_answer'] =  ucwords(strtolower($this->request->data['faq_answer']));
            $faq['faq_question'] =  ucwords(strtolower($this->request->data['faq_question']));
            if ($this->request->data['image']['tmp_name']) {
                $ext = pathinfo($this->request->data['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . "." . $ext;
                $path = "faq_images/" . $filename;
                move_uploaded_file($this->request->data['image']['tmp_name'], $path);
                unlink("faq_images/" . $faq['image']);
                $this->request->data['image'] = $filename;
                $faq['image']  = $filename;
               
            }
            $this->Faq->save($faq);
            $this->Flash->success(__('Faq  Update Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
        
    }


    public function delete($id)
    {  
        $this->autoRender = false;
        $result = $this->Faq->get($id);
        unlink("faq_images/" . $result['image']);
        if ($this->Faq->delete($result)) {
            $this->Flash->error(('Faq Category delete Successfully'));
            return $this->redirect(['action' => 'index']);
        }
    }


        
	public function status($id, $status)
	{
        $this->autoRender = false;
		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {
				$status = 'N';
				$classes = $this->Faq->get($id);
				$classes->status = $status;
				if ($this->Faq->save($classes)) {
					$this->Flash->error(__('status has been Deactive.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = 'Y';
				$classes = $this->Faq->get($id);
				$classes->status = $status;
				if ($this->Faq->save($classes)) {
					$this->Flash->success(__('status has been Active.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}




   // Faq Category Controller Functions :-


   // Faq Category index
    public function faqcatindex()
    {
        $this->loadModel('FaqCategory');
        $this->viewBuilder()->layout('admin');
        $result = $this->FaqCategory->find('all')->order(['FaqCategory.id'=>'DESC'])->toarray();
        $this->set(compact(['result']));
    }

    // Add Faq Category 
    public function faqcatadd()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('FaqCategory');
        if ($this->request->is('post')) {
            $faqcategory = $this->FaqCategory->newEntity();
            $faqcategory['category_name'] = ucwords(strtolower($this->request->data['category_name']));
            $this->FaqCategory->save($faqcategory);
            $this->Flash->success(__('Faq Category Successfully Saved.'));
            return $this->redirect(['action' => 'faqcatindex']);
        }
    }

    //Edit Faq Category
    public function faqcatedit($id)
    {
        $this->loadModel('FaqCategory');
        $this->viewBuilder()->layout('admin');
        $result = $this->FaqCategory->find('all')->where(['id' => $id])->first();
        $this->set(compact(['result']));
        if ($this->request->is(['post', 'put'])) {
            $result['category_name'] =  ucwords(strtolower($this->request->data['category_name']));
            $this->FaqCategory->save($result);
            $this->Flash->success(__('Faq Category Update Successfully.'));
            return $this->redirect(['action' => 'faqcatindex']);
        }
    }

    // Delete Faq Category Controller
    public function faqcatdelete($id)
    {  

        $this->loadModel('Faq');
        $countfaq = $this->Faq->find('all')->where(['category_id' => $id])->count();
        if($countfaq > 0){
            $this->Flash->error(('Faq Category is used in another module so you can not delete this.'));
            return $this->redirect(['action' => 'faqcatindex']);
        }
      

        $this->loadModel('FaqCategory');
        $this->autoRender = false;
        $result = $this->FaqCategory->get($id);
        if ($this->FaqCategory->delete($result)) {
            $this->Flash->error(('Faq Category delete Successfully'));
            return $this->redirect(['action' => 'faqcatindex']);
        }
    }

    // For Update Status
	public function faqcatstatus($id, $status)
	{
        $this->loadModel('FaqCategory');

        $this->autoRender = false;
		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {

				$status = 'N';
				$result = $this->FaqCategory->get($id);
				$result->status = $status;
				if ($this->FaqCategory->save($result)) {
					$this->Flash->error(__('Status has been Deactive.'));
					return $this->redirect(['action' => 'faqcatindex']);
				}
			} else {

				$status = 'Y';
				$result = $this->FaqCategory->get($id);
				$result->status = $status;
				if ($this->FaqCategory->save($result)) {
					$this->Flash->success(__('Status has been Active.'));
					return $this->redirect(['action' => 'faqcatindex']);
				}
			}
		}
	}




}
