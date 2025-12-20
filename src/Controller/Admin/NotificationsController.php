<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use MyClass\MyClass;

class NotificationsController extends AppController
{
    public $helpers = ['CakeJs.Js'];

    public function setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    public function initialize()
    {
        parent::initialize();
    }


    // Get all student token 
    public function getAllTokens($class_id = null, $section_id = null, $usertype = null)
    {
       
        $this->loadModel('Students');
        $tokens = array();
        if ($usertype == 'Student') {
            $dataofass = $this->Students->find('all')->where(['class_id' => $class_id, 'section_id' => $section_id])->toarray();
        } else {
            $this->loadModel('Employees');
            $dataofass = $this->Employees->find('all')->where(['status' => 'Y', 'is_drop' => 'N'])->order(['id' => 'DESC'])->toArray();
        }
        foreach ($dataofass as $value) { //pr($value); die;
            if (!empty($value['token'])) {
                array_push($tokens, $value['token']);
            }
        }
        //   print_r($tokens); die;
        return $tokens;
    }



    public function index()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Notification');
        $this->loadModel('Classections');
        $this->loadModel('Sections');
        $Classections = $this->Classections->find('all')->select(['class_id', 'section_id', 'id'])->contain(['Classes', 'Sections'])->toarray();
        foreach ($Classections as $key => $va) {
            // pr($va);die;
            $sec[] = $va['section_id'];
            $cls[] = $va['class_id'];
        }
        $this->set(compact('sec', 'cls'));

        $notifications = $this->Notification->find('all')->order(['Notification.create_date' => 'desc'])->toarray();
        $this->set(compact('notifications'));
    }

    public function add()
    {

        require_once 'Firebase.php';
        require_once 'Push.php';

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Sections');
        $this->loadModel('Classes');
        $this->loadModel('Classections');
        $this->loadModel('Notification');

        $db = $this->request->session()->read('Auth.User.db');

        $Classections = $this->Classections->find('all')->select(['class_id', 'section_id', 'id'])->contain(['Classes', 'Sections'])->toarray();
        // pr($db);die;
        foreach ($Classections as $key => $va) {
            $sec[] = $va['section_id'];
            $cls[] = $va['class_id'];
        }
        $this->set(compact('sec', 'cls'));

        if ($this->request->is(['post', 'put'])) {


            $type = $this->request->data['type'];
            $types = str_replace(' ', '_', $type);
            // pr($types); die;
            $description = $this->request->data['description'];
            $image = $this->request->data['image'];

            if ($types == 'Student') {

                foreach ($this->request->data['class_id'] as $Classections) {
                    // pr($Classections)
                    $class = strval($Classections);
                    $str = $class;
                    $class_sec = (explode("-", $str));
                    $class_id = $class_sec[0];
                    $sec_id = $class_sec[1];

                    $notifications = $this->Notification->newEntity();
                 
                    $notification_data['message'] = $description;
                    $notification_data['type'] = $type;
                    $notification_data['class_id'] = $class_id;
                    $notification_data['section_id'] = $sec_id;
                    $notification_data['image'] = $image;

                    if ($notification_data['image']) {

                        foreach ($notification_data['image']  as $val) {
                            // pr($val);

                            $imagefilename = $val['name'];
                            $imagefiletype = $val['type'];
                            $item = $val['tmp_name'];
                            $ext =  end(explode('.', $imagefilename));
                            $name = md5(uniqid($filename));
                            $imagename = $name . '.' . $ext;
                            $db = $this->request->session()->read('Auth.User.db');
                            $path  = '/var/www/html/idsprime/webroot/' . $db . "_image/" . $imagename;

                            if (move_uploaded_file($item, $path)) {
                                $test  =  $imagename;
                                $test2[] = $test;
                                $test3 = implode(',', $test2);
                            }
                        }

                        $notification_data['image'] = $test3;
                    }
                    $notifications = $this->Notification->patchEntity($notifications, $notification_data);
                    // pr($notifications); die;
                    $this->Notification->save($notifications);

                    // Sent notification

                    $devicetoken = $this->getAllTokens($class_id,$sec_id,$type);
                //   print_r($devicetoken); die;
                    $push = new \Push(
                        $db,
                        $description
                    );

                    $firebase = new \Firebase();
                    $mPushNotification = $push->getPush();
                    // print_r( $mPushNotification); die;

                    $test = $firebase->send($devicetoken, $mPushNotification); //die;
                    //   print_r($test);exit;
                }

                $this->Flash->success(__("Notifications has been sent all Student Successfully"));
                return $this->redirect(['action' => 'index']);
            } else if ($types == 'Staff') {
                
                $notifications = $this->Notification->newEntity();
                $notification_data['message'] = $description;
                $notification_data['type'] = 'Teacher';
                $notification_data['image'] = $image;

                if ($notification_data['image']) {

                    foreach ($notification_data['image']  as $val) {
                        // pr($val);

                        $imagefilename = $val['name'];
                        $imagefiletype = $val['type'];
                        $item = $val['tmp_name'];
                        $ext =  end(explode('.', $imagefilename));
                        $name = md5(uniqid($filename));
                        $imagename = $name . '.' . $ext;
                        $db = $this->request->session()->read('Auth.User.db');
                        $path  = '/var/www/html/idsprime/webroot/' . $db . "_image/" . $imagename;

                        if (move_uploaded_file($item, $path)) {
                            $test  =  $imagename;
                            $test2[] = $test;
                            $test3 = implode(',', $test2);
                        }
                    }

                    $notification_data['image'] = $test3;
                }
                $notifications = $this->Notification->patchEntity($notifications, $notification_data);
                $this->Notification->save($notifications);
                // Sent notification
                  $devicetoken = $this->getAllTokens($class_id=null,$sec_id=null,$types);
                  // pr($devicetoken); die;
                  $push = new \Push(
                      $db,
                      $description
                    );
                    $firebase = new \Firebase();
                    $mPushNotification = $push->getPush();
                    //   pr($mPushNotification); die;
                  $test = $firebase->send($devicetoken, $mPushNotification); 
                //   pr($test); die;
              
                $this->Flash->success(__("Notifications been sent all Staff Successfully"));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("Sorry notifications not sent please select valide type"));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    public function delete($id = null)
    {
        $this->loadModel('Notification');

        $this->Notification->delete($this->Notification->get($id));

        $this->Flash->success(__("Notifications has been Deleted Successfully"));
        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $this->loadModel('Notification');

        $type = $this->request->data['type'];
        $types = str_replace(' ', '_', $type);

        $class = strval($this->request->data['class_section']);
        $class_sec = (explode("-", $class));
        $class_id = $class_sec[0];
        $sec_id = $class_sec[1];

        $cond = [];
        if (!empty($class_id)  && !empty($sec_id) && $types == 'Student') {
            $cond['Notification.class_id'] = $class_id;
            $cond['Notification.section_id'] = $sec_id;
            $cond['Notification.type LIKE'] = $types;
        } else {
            $cond['Notification.type LIKE'] = $types;
        }
        $notifications = $this->Notification->find('all')->where([$cond])->order(['Notification.id' => 'Desc'])->toarray();
        // pr($Notifications); die;
        $this->set(compact('notifications'));
    }

    public function status($id, $work)
    {
        $this->loadModel('Notification');
        if (isset($id) && !empty($id)) {
            if ($work == 'Y') {

                $work = 'N';
                $user = $this->Notification->get($id);

                $user->featured = $status;
                if ($this->Notification->save($user)) {
                    $this->Flash->success(__('Notification status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $work = 'Y';
                $user = $this->Notification->get($id);
                $user->featured = $work;
                if ($this->Notification->save($user)) {
                    $this->Flash->success(__('Notification status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
}
