<?php

namespace App\Controller\Admin;

use App\Controller\AppController;

class FeedbacksController extends AppController
{



    	//initialize component
	public function initialize()
	{
		parent::initialize();
        $this->loadModel('Classes');
        $this->loadModel('Sections');
        $this->loadModel('FeedBacks');
        $this->loadModel('FeedbackCat');
        $this->loadModel('Sections');
        $this->loadModel('Users');
        $this->loadModel('Sections');

	}


    public function connection($dbs)
    {
        ConnectionManager::config($dbs, [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => MYSQLHOST,
            'username' => MYSQLUESRNAME,
            'password' => MYSQLPASSWORD,        
            'database' => $dbs,
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
        ]);
        ConnectionManager::drop('default');
        ConnectionManager::get($dbs);
        \Cake\Datasource\ConnectionManager::alias($dbs, 'default');
    }


    public function index()
    {
        $this->viewBuilder()->layout('admin');
        $classes = $this->Classes->find('list', ['keyField' => 'title', 'valueField' => 'title'])->toarray();
        $sections = $this->Sections->find('list', ['keyField' => 'id', 'valueField' => 'title'])->toarray();
        $feedbacks = $this->FeedBacks->find('all')->contain(['FeedbackCat'])->order(['FeedBacks.id' => 'DESC'])->toarray();
        $this->set(compact('feedbacks', 'classes', 'sections'));
    }


    public function feedback_search()
    {
        $this->viewBuilder()->layout(false);
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($this->request->is('post')) {
            if (!empty($this->request->data['class_id'])) {
                $con['FeedBacks.class'] = $this->request->data['class_id'];
            }
            if (!empty($this->request->data['name'])) {
                $con['Students.fname LIKE'] = '%'. $this->request->data['name'] . '%';
            }
            if (!empty($this->request->data['d1'])) {
                $con['DATE(FeedBacks.created) >='] = date('Y-m-d', strtotime($this->request->data['d1']));
            }
            if (!empty($this->request->data['d2'])) {
                $con['DATE(FeedBacks.created) <='] = date('Y-m-d', strtotime($this->request->data['d2']));
            }
            // $classes = $this->Classes->find('list', ['keyField' => 'title', 'valueField' => 'title'])->toarray();
            // $sections = $this->Sections->find('list', ['keyField' => 'id', 'valueField' => 'title'])->toarray();
            $feedbacks = $this->FeedBacks->find('all')->contain(['FeedbackCat','Students'])->where($con)->order(['FeedBacks.id' => 'DESC'])->toarray();
            $this->set(compact('feedbacks', 'classes', 'sections'));
        }
    }
    public function close()
    {
        $this->viewBuilder()->layout(false);
        if ($this->request->is('post')) {
        
            $feedback = $this->FeedBacks->get($this->request->data['feedback_id']);
            $feedback->status = 'Y';
            $feedback->remarks = $this->request->data['closing_remark'];
            $feedback->closing_date = date('Y-m-d');
            $this->FeedBacks->save($feedback);
            $this->Flash->success(__('Feedback closed Successfully'));
            return $this->redirect($this->referer());
        }
    }



    public function branchfeedback()
    {
        $this->viewBuilder()->layout('admin');
        $branch_namesss = $this->Users->find('all')->where(['role_id' => BRANCH_HEAD])->toarray();
        $branch_list = $branch_namesss[0]['franchise_db'];
        $expload_branch_name = explode(',', $branch_list);
        sort($expload_branch_name);
        $this->set(compact('expload_branch_name'));
    }



    public function search()
    {
        $this->viewBuilder()->layout(false);
        $branch_name = $this->request->data['branch_name'];
        $status = $this->request->data['status'];
        $this->set(compact('branch_name', 'status'));
    }
}
