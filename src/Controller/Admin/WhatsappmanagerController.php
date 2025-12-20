<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;

class WhatsappmanagerController extends AppController
{
    public function connection($dbname)
    {
        ConnectionManager::config($dbname, [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => MYSQLHOST,
            'username' => MYSQLUESRNAME,
            'password' => MYSQLPASSWORD,
            'database' => $dbname,
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
        ]);
    }

    public function beforeFilter(Event $event)
    {

        parent::beforeFilter($event);
        $this->loadComponent('Cookie');
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['whatsappbalancealert']);
    }


    // $this->Auth->allow(['whatsappbalancealert']);

    public function index()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Smsmastersetting');
        $this->loadModel('Schools');
        $this->loadModel('Users');

        // $users = $this->Smsmastersetting->find('all')->group('Smsmastersetting.client_id')->contain(['Schools'])->order(['Smsmastersetting.purchase_date' => 'desc'])->toarray();
        $connss = ConnectionManager::get('default');
        $query2 = "SELECT * 
        FROM (
            SELECT * FROM school_erp.sms_master
            ORDER BY purchase_date Desc 
        ) AS sub
        GROUP BY client_id";
        $users = $connss->execute($query2)->fetchAll('assoc');
        // pr($users);exit;




        $this->set('users', $users);
    }

    public function add()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Smsmastersetting');
        $this->loadModel('Schools');

        $franchise_schools = $this->Schools->find('list', array('keyField' => 'id', 'valueField' => 'school_name'))->where(['franchise_type' => '0'])->toarray();
        $this->set('franchise_schools', $franchise_schools);

        $users = $this->Smsmastersetting->find('all')->contain(['Schools'])->order(['Smsmastersetting.id' => 'ASC'])->toarray();
        $this->set('users', $users);


        $sms_details = $this->Smsmastersetting->newEntity();

        if ($this->request->is(['post', 'put'])) {

            $data['client_id'] = $this->request->data['client_id'];
            $data['purchase_date'] = date('Y-m-d', strtotime($this->request->data['purchase_date']));
            $data['message_count'] = $this->request->data['message_count'];
            $data['payment_mode'] = $this->request->data['payment_mode'];
            $data['reference_no'] = $this->request->data['reference_no'];
            $data['amount'] = $this->request->data['amount'];

            $sms_data = $this->Smsmastersetting->patchEntity($sms_details, $data);

            $sms_save = $this->Smsmastersetting->save($sms_data);
            if ($sms_save) {

                $cln_id = $sms_save['client_id'];
                $sms_cnt = $sms_save['message_count'];
                $school_total_count = $this->Schools->find('all')->where(['id' => $cln_id])->first();
                $total_msg = $school_total_count['msg_count'] + $sms_cnt;

                $conn = ConnectionManager::get('default');
                $conn->execute("UPDATE `school_erp`.`schools` SET `msg_count`='$total_msg' WHERE id='$cln_id'");


                $this->Flash->success(__('SMS Details has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    //delete functionality
    public function delete($id)
    {
        $this->loadModel('Smsmastersetting');
        $classes = $this->Smsmastersetting->get($id);
        // pr($classes); die;
        $delet_msg_count = $classes['message_count'];
        $client_id = $classes['client_id'];

        $data = $this->Smsmastersetting->find('all')->contain(['Schools'])->where(['Smsmastersetting.client_id' => $client_id])->toarray();

        $msg_curr_count = $data[0]['school']['msg_count'];
        $update_count = $msg_curr_count - $delet_msg_count;

        $conn = ConnectionManager::get('default');
        $conn->execute("UPDATE `school_erp`.`schools` SET `msg_count`='$update_count' WHERE id='$client_id'");

        if ($this->Smsmastersetting->delete($classes)) {
            $this->Flash->success(__(' Data with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }


    // search functionality
    public function search()
    {
        $this->loadModel('Smsmastersetting');
        $this->loadModel('Schools');

        $client_id = $this->request->data['id'];
        $cond = [];
        if (isset($client_id) && $client_id != '') {
            $cond['Smsmastersetting.client_id'] = $client_id;
        }
        $users = $this->Smsmastersetting->find('all')->contain(['Schools'])->where([$cond])->order(['Smsmastersetting.id' => 'ASC'])->toarray();
        $this->set('users', $users);
    }

    // show data in all school
    public function msgdetails()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Users');
        $id = $this->request->session()->read('Auth.User.c_id');
        $db = $this->request->session()->read('Auth.User.db');

        $this->connection('school_erp');
        $connss = ConnectionManager::get('school_erp');
        $query1 = "SELECT school_erp.sms_master.*,school_erp.schools.school_name FROM school_erp.sms_master Left JOIN school_erp.schools
         ON school_erp.sms_master.client_id = school_erp.schools.id where sms_master.client_id='$id' group by client_id ";
        $resultall = $connss->execute($query1)->fetchAll('assoc');

        // total recharge group by school name
        $connss = ConnectionManager::get('school_erp');
        $query2 = "SELECT sum(message_count) as count FROM school_erp.sms_master group by client_id ";
        $resultall1 = $connss->execute($query2)->fetchAll('assoc');

        foreach ($resultall1 as $value) {
            $datass = $value;
        }
        $this->set('total_msg', $datass);

        // collect sent sms data from all schools sms tables
        $branch_namesss = $this->Users->find('all')->where(['role_id' => '105'])->toarray();
        $branch_list = $branch_namesss[0]['franchise_db'];
        $expload_branch_name = explode(',', $branch_list);

        if ($db != 'canvas') {
            // $this->connection($db);
            $conect_new = ConnectionManager::get('default');
            $sintall = "SELECT count(*) as sms_count FROM sms_deliveries;";
            $rinstall = $conect_new->execute($sintall)->fetch('assoc');
            $sms_count[] = $rinstall['sms_count'];
        } else {

            foreach ($expload_branch_name as $value) {

                $this->connection($value);
                $conect_new = ConnectionManager::get($value);
                $sintall = "SELECT count(*) as sms_count FROM sms_deliveries;";
                $rinstall = $conect_new->execute($sintall)->fetch('assoc');
                $sms_count[] = $rinstall['sms_count'];
            }
        }
        $this->set('sms_count', array_sum($sms_count));
        $this->set(compact('resultall'));
    }


    // corn msg send function all schools
    public function whatsappbalancealert()
    {

        $this->autoRender = false;
        $connss = ConnectionManager::get('default');
        $query2 = "SELECT * FROM school_erp.schools where whatsapp_token !='' and msg_count < 500
    ";
        $result = $connss->execute($query2)->fetchAll('assoc');

        if ($result) {
            foreach ($result as $valus) {

                $to = "+919636293152";
                $message = "Hello Sanjay Kumar !!!!";

                $wp_msg = $this->supperadminwhatsapp($to, $message);
            }
        }
    }
}
