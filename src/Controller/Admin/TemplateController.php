<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class TemplateController extends AppController
{
    public function index($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Template');
        $this->loadModel('TemplateCategory');
        $temp_cat = $this->TemplateCategory->find('list', ['keyField' => 'name', 'valueField' => 'name'])->toarray();
        $this->set(compact('temp_cat'));
        if (!empty($id)) {
            $template = $this->Template->get($id);
            $this->set(compact('template'));
        }
        //pr($this->request->data);die;

        if ($this->request->is('post') || $this->request->is('put')) {
            // echo "ok";
            $new = $this->Template->newEntity();
            if (!empty($this->request->data['edit'])) {
                $new = $this->Template->get($id);
            }
            $this->request->data['category']=implode(',',$this->request->data['category']);
            $patch = $this->Template->patchEntity($new, $this->request->data);
            if ($this->Template->save($new)) {
                $this->Flash->success(__('Template Added Successfully'));
                $this->redirect(['action' => 'index']);

            }

        }
        $templates = $this->Template->find('all')->toarray();
        //pr($templates);die;
        $this->set(compact('templates'));
    }
    public function delete($id)
    {
        $this->loadModel('Template');
        $det = $this->Template->get($id);
        if ($this->Template->delete($det)) {
            $this->Flash->success(__('Template Deleted Successfully'));
            $this->redirect(['action' => 'index']);
        }
    }
    public function view($id)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Template');
        $this->loadModel('Sitesettings');
        $db = $this->request->session()->read('Auth.User.db');
        $det = $this->Template->get($id);
        $this->set(compact('det','db'));
        $sitesetting = $this->Sitesettings->find('all')->first();
        $this->set(compact('sitesetting'));
        //pr($sitesetting);die;
    }
    public function status($id)
    {
        $this->autoRender = false;
        $conn = ConnectionManager::get('default');
        $detail = 'UPDATE `report_template` SET `status` ="N" where 1=1';
        $results = $conn->execute($detail);
        $this->loadModel('Template');
        $det = $this->Template->get($id);
        $data['status'] = 'Y';
        $patch = $this->Template->patchEntity($det, $data);
        if ($this->Template->save($patch)) {
            $this->Flash->success(__('Template Updated Successfully'));
            $this->redirect(['action' => 'index']);
        }

    }

}