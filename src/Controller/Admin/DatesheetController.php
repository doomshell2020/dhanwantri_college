<?php
namespace App\Controller\Admin;
use Cake\Http\Client;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;

use App\Controller\AppController;

class DatesheetController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Classes');
        $this->loadmodel('Datesheet');
        $this->loadmodel('Users');
        $db = $this->Users->find()->where(['role_id' => 1])->first();
		$this->set(compact('db'));
        $sheet_det = $this->Datesheet->find('all')->order(['id' => 'DESC'])->toarray();
       
        $class_id = $this->Classes->find('list')->select(['id', 'title'])->order(['sort' => 'ASC'])->toarray();

        $this->set('class_id', $class_id);
        $this->set('sheet_det', $sheet_det);

    }
    public function add()
    {
        $this->autoRender = false;
        $this->loadmodel('Datesheet');

        if ($this->request->is('post')) {
            // pr($this->request->data);die;
            $create_data = $this->Datesheet->newEntity();
            // $class_id = implode(',', $this->request->data['class_id']);
            // $this->request->data['class_id'] = $class_id;
            $this->request->data['start_date'] = date('Y-m-d', strtotime($this->request->data['start_date']));
            $this->request->data['end_date'] = date('Y-m-d', strtotime($this->request->data['end_date']));
            $tmp_name = $this->request->data['sheet_name']['tmp_name'];
            $image_name = $this->request->data['sheet_name']['name'];
            
            $pext = pathinfo($image_name, PATHINFO_EXTENSION);
            $imagenewname = md5(time($filename)) . '.' . $pext;
            // $dest = '/var/www/html/idsprime/webroot/img/';
				$dest = WWW_ROOT . 'img/';

                $newfile = $dest . $imagenewname;
            if (move_uploaded_file($tmp_name, $newfile)) {
            
                $this->request->data['sheet_name'] = $imagenewname;
                $entity = $this->Datesheet->patchEntity($create_data, $this->request->data);

                if ($this->Datesheet->save($entity)) {
                    $this->Flash->success(__('Datesheet added successfully'));

                    return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('Datesheet not added'));

                    return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
                }
            } else {
                $this->Flash->error(__('Error in uploading'));

                return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
            }

        }
    }
    // public function delete($id)
    // {
    //     $this->loadModel('Datesheet');
    //     $this->autoRender = false;
    //     $res = $this->Datesheet->get($id);
    //     if ($this->Datesheet->delete($res)) {
    //         $this->Flash->success('Datesheet deleted successfully');
    //         return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
    //     } else {
    //         $this->Flash->error('Datesheet not  delete successfully');
    //         return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
    //     }
    // }
    
    public function delete($id)
    {
        $this->loadModel('Datesheet');
        $search = $this->Datesheet->find('all')->where(['id' => $id])->first();
        if ($search) {
            $res = $this->Datesheet->get($id);
            if ($res) {
                if ($this->Datesheet->delete($res)) {
                    $this->Flash->success('Datesheet deleted successfully');
                    return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
                } else {
                    $this->Flash->error('Failed to delete the Datesheet');
                    return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
                }
            } else {
                $this->Flash->error('Datesheet not found');
            }
        }
        return $this->redirect($this->referer());
    }

    public function edit($id)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Classes');
        $class_id = $this->Classes->find('list')->select(['id', 'title'])->order(['sort' => 'ASC'])->toarray();
        $this->set('class_id', $class_id);
        $this->loadModel('Datesheet');
        $sheet_det = $this->Datesheet->get($id);
        $this->set('sheet_det', $sheet_det);
        if ($this->request->is(['post', 'put'])) {
            $det = $this->Datesheet->get($id);
            $class_ids = implode(',', $this->request->data['class_id']);
            $this->request->data['class_id'] = $class_ids;
            $sheet_name = $this->request->data['sheet_name'];

            if (!empty($sheet_name['name'])) {
                $tmp_name = $this->request->data['sheet_name']['tmp_name'];
                $image_name = $this->request->data['sheet_name']['name'];
                $pext = pathinfo($image_name, PATHINFO_EXTENSION);
                $imagenewname = md5(time($filename)) . '.' . $pext;
                $dest = "/var/www/html/idsprime/webroot/img/";
                $newfile = $dest . $imagenewname;
              
                if (move_uploaded_file($tmp_name, $newfile)) {
                   
                    unlink('/var/www/html/idsprime/webroot/img/' . $det['sheet_name']);
                    $this->request->data['sheet_name'] = $imagenewname;
                    $entity = $this->Datesheet->patchEntity($det, $this->request->data);
                }
            } else {
                //echo "ok";die;
                $this->request->data['sheet_name'] = $det['sheet_name'];
                $entity = $this->Datesheet->patchEntity($det, $this->request->data);
            }
            if ($this->Datesheet->save($entity)) {
                $this->Flash->success(__('Datesheet edited successfully'));

                return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
            } else {
                $this->Flash->error(__('Datesheet not added'));

                return $this->redirect(['controller' => 'Datesheet', 'action' => 'index']);
            }
        }
    }
}
